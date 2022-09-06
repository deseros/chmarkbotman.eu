<?php

namespace App\Http\Controllers\BotComment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;
use Telegram\Bot\Actions;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Api;
use Telegram;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Answers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
       
    }

    public function setwebhook()
  {
    $response = Telegram::setWebhook(['url' => env('APP_URL') .'/commentwebhook', 'drop_pending_updates' => true]);
    dd($response);
  }
  public function setwebhookmain()
  {
    $response = Http::get('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/setWebhook?url='. env('APP_URL') . '/botman&drop_pending_updates=true');
    dd($response->successful());
  }
   public function mywebhook(){
   $telegramus = $this->telegram->commandsHandler(true); 
   $telegram_user = $this->telegram->getWebhookUpdate()->getMessage();
   if(isset($telegram_user['from']['first_name'])){
     $username = $telegram_user['from']['first_name'];
   }
   else if(isset($telegram_user['from']['last_name'])){
    $username = $telegram_user['from']['last_name'];
  }
  
    if(isset($telegram_user['reply_to_message'])){
    if(isset($telegram_user['text']))
    {
      if(DB::table('tickets')->where('tg_channel_msg_id', '=', $telegram_user['reply_to_message']['forward_from_message_id'])->exists())
      {
        DB::table('ticket_replies')->insert(['ticket_id' => $telegram_user['reply_to_message']['forward_from_message_id'], 
        'replies' => $telegram_user['text'], 
        'username' => isset($telegram_user['from']['first_name']) ? $telegram_user['from']['first_name'] : 'Клиент',
        'created_at' => date( 'Y/m/d H:i:s')]);
      }
    }
    if(isset($telegram_user['photo']))
    {
      if(DB::table('tickets')->where('tg_channel_msg_id', '=', $telegram_user['reply_to_message']['forward_from_message_id'])->exists())
      {

        $telegram_id_file = $telegram_user['photo'][3]['file_id'];
        $file_id = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN_COMMENT'). "/getFile?file_id=" . $telegram_id_file;
        $file_request = json_decode(Http::get($file_id)->getBody(),true);
        $file_url = "https://api.telegram.org/file/bot" . env('TELEGRAM_BOT_TOKEN_COMMENT') . "/" . $file_request['result']['file_path'];
        $id_client = DB::table('client_telegram_ids')->where('telegram_id', '=',$telegram_user['from']['id'])->first()->clients_id;
        $save_media = file_get_contents($file_url);
        $file_name = Str::random(10) . '.jpg';
       Storage::disk('images')->put($id_client .'/replies/image/' . $file_name, $save_media);
       DB::table('replies_medias')->insert([
         'ticket_id' => $telegram_user['reply_to_message']['forward_from_message_id'], 
         'mime_type' => "photo",
         'file_name' => $file_name, 
         'file_path' => $id_client .'/replies/image/' . $file_name,
         'caption' => isset($telegram_user['caption']) ? $telegram_user['caption'] : null,
         'username' => isset($telegram_user['from']['first_name']) ? $telegram_user['from']['first_name'] : 'Клиент',
         'created_at' => date( 'Y/m/d H:i:s')]
        );
        
      }
    }
    if(isset($telegram_user['document']))
    {
      if(DB::table('tickets')->where('tg_channel_msg_id', '=', $telegram_user['reply_to_message']['forward_from_message_id'])->exists())
      {
        $telegram_id_file = $telegram_user['document']['file_id'];
        $file_id = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN_COMMENT'). "/getFile?file_id=" . $telegram_id_file;
        $file_request = json_decode(Http::get($file_id)->getBody(),true);
        $file_url = "https://api.telegram.org/file/bot" . env('TELEGRAM_BOT_TOKEN_COMMENT') . "/" . $file_request['result']['file_path'];
        $id_client = DB::table('client_telegram_ids')->where('telegram_id', '=',$telegram_user['from']['id'])->first()->clients_id;
        $save_media = file_get_contents($file_url);
       Storage::disk('images')->put($id_client .'/replies/document/' . $telegram_user['document']['file_name'], $save_media);
       DB::table('replies_medias')->insert([
         'ticket_id' => $telegram_user['reply_to_message']['forward_from_message_id'], 
         'mime_type' => "document",
         'file_name' => $telegram_user['document']['file_name'], 
         'file_path' => $id_client .'/replies/document/' . $telegram_user['document']['file_name'],
         'caption' => isset($telegram_user['caption']) ? $telegram_user['caption'] : null,
         'username' => isset($telegram_user['from']['first_name']) ? $telegram_user['from']['first_name'] : 'Клиент',
         'created_at' => date( 'Y/m/d H:i:s')]
        );
      }
    }
  }
  else{
   //Telegram::deleteMessage(['chat_id' => $telegram_user['chat']['id'], 'message_id' => $telegram_user['message_id']]);
   //Telegram::sendMessage(['chat_id' => $telegram_user['chat']['id'], 'text' => '<b>Выполняйте ответ на обращение в его обсуждении</b>', 'parse_mode' => 'HTML' ]);

 
  }
}
}