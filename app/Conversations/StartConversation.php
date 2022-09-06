<?php

namespace App\Conversations;

use BotMan\BotMan\BotMan;
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\BotManFactory;
use App\Conversations\ExampleConversation;
use Illuminate\Support\Facades\Log;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\ClientTelegramId;
class StartConversation extends Conversation
{
   
    protected object $botman;

    public function __construct(object $botman  = null)
    {
      $this->botman = $botman = app('botman');
      
    }
    public function bot_start(){
        $this->ask('Введите ключ, выданный нашими специалистами', function(Answer $answer) {
            // Save result
            $key = $answer->getText();
            $user = $this->botman->getUser();
            $id = $user->getId();
            $testok = new \App\Models\Client();
            $check_key = $testok->where('key_license_telegram', '=', $key)->exists();
            if(empty($check_key)){
                $this->reply_key();
            }
            else{
                $find_id_client = json_decode($testok->where('key_license_telegram', '=', $key)->first(), true);
                $check_user = ClientTelegramId::where('telegram_id', '=', $id)->exists();
                if(!empty($check_user)){
                    $keyboard = Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
                    ->oneTimeKeyboard(true)
                    ->resizeKeyboard(true)
                    ->addRow( 
                       KeyboardButton::create("Начать ввод обращения")->callbackData('send_ticket')
                    )
                    ->toArray();
                    $this->say("Вы уже добавлены в базу клиентов.", $keyboard);
                }
                else{
                    ClientTelegramId::insert(array(
                        'clients_id' => $find_id_client['id'],
                        'telegram_id' => $id
                    ));
                    $keyboard = Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
                    ->oneTimeKeyboard(true)
                    ->resizeKeyboard(true)
                    ->addRow( 
                       KeyboardButton::create("Начать ввод обращения")->callbackData('send_ticket')
                    )
                    ->toArray();
                    $this->say("Вы авторизованы. Если хотите начать вводить обращение, нажмите кнопку.", $keyboard);          
            }
            }
        });
    }
    public function reply_key(){
        $this->ask('Ключ неверный, повторите попытку. Если у вас нет ключа, обратитесь в службу технической поддержки.', function(Answer $answer) {
            // Save result
            $key = $answer->getText();
            $user = $this->botman->getUser();
            $id = $user->getId();
            $testok = new \App\Models\Client();
            $check_key = $testok->where('key_license_telegram', '=', $key)->exists();
            if(empty($check_key)){
          $this->reply_key();
            }
            else{    
                $find_id_client = json_decode($testok->where('key_license_telegram', '=', $key)->first(), true);
                $check_user = ClientTelegramId::where('telegram_id', '=', $id)->exists();
                if(!empty($check_user)){
                    $keyboard = Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
                    ->oneTimeKeyboard(true)
                    ->resizeKeyboard(true)
                    ->addRow( 
                       KeyboardButton::create("Начать ввод обращения")->callbackData('send_ticket')
                    )
                    ->toArray();
                    $this->say("Вы уже были добавлены в базу клиентов", $keyboard);
                }
                else{      
                ClientTelegramId::insert(array(
                    'clients_id' => $find_id_client['id'],
                    'telegram_id' => $id
                ));
                $keyboard = Keyboard::create()->type( Keyboard::TYPE_KEYBOARD )
                    ->oneTimeKeyboard(true)
                    ->resizeKeyboard(true)
                    ->addRow( 
                       KeyboardButton::create("Начать ввод обращения")->callbackData('send_ticket')
                    )
                    ->toArray();
                    $this->say("Ключ принят. Для начала работы с ботом нажмите кнопку «Начать ввод обращения».", $keyboard);  
            }
            }
        });
    }
    public function run()
    {
        // This will be called immediately
        $this->bot_start();
    }
}
