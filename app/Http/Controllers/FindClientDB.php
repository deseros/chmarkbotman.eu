<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\BotManFactory;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\ClientTelegramId;
use App\Models\TicketMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FindClientDB extends Controller
{

  protected object $botman;

  //protected object $telegram_data;
  public function __construct(object $botman = null)
  {
    $this->botman = $botman = app('botman');
  }
  public function find_client()
  {

    $user = $this->botman->getUser();
    $id_user = $user->getId();
    $current_user = ClientTelegramId::where('telegram_id', '=', $id_user)->first();
    $user_in_client = Client::find(isset($current_user['clients_id']) ? $current_user['clients_id'] : null);
    return $user_in_client;
  }
  public function find_last_ticket()
  {
    $search_ticket = json_decode(Ticket::where('client_id', '=', $this->find_client()['id'])->latest()->limit(1)->get(), true);
    return $search_ticket;
  }
  public function find_media_last_ticket()
  {
    $media_box = [];
    $search_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->get();
    foreach ($search_media as $media_item) {
      $media_box[] = 'n' . $media_item->bx_id_file;
    }
    return $media_box;
  }
  public function packed_photo_posting()
  {
    $media_box = [];
    $upd_media_box = [];
    $search_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'photo')->limit(10)->get();
    foreach ($search_media as $media_item) {
      $media_box[] = ['type' => 'photo', 'media' => $media_item->media_uuid, 'caption' => ''];
    }
    $link_bot = "⚙️ Для отправки обращения перейдите в @chmarkbot_bot";
    $ticket_desk  = Str::substr($this->find_last_ticket()[0]['description'], 0, 900);
    $cap_text = '❗️ Открыто новое обращение №' . $this->find_last_ticket()[0]['bx_ticket_id'] . "\n" . $this->find_last_ticket()[0]['subject'] . "\n" . "\n" . $ticket_desk . "\n" .  "\n" . '________' . "\n" . $link_bot;
    $media_box[0]['caption'] = $cap_text;
    return  $media_box;
  }
  public function packed_all_posting()
  {
    $media_box = [];
    $upd_media_box = [];
    $search_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'photo')->limit(10)->get();
    $count_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'document')->count();
    foreach ($search_media as $media_item) {
      $media_box[] = ['type' => 'photo', 'media' => $media_item->media_uuid, 'caption' => ''];
    }
    $link_bot = "⚙️ Для отправки обращения перейдите в @chmarkbot_bot";
    $ticket_desk  = Str::substr($this->find_last_ticket()[0]['description'], 0, 900);
    $cap_text = '❗️ Открыто новое обращение №' . $this->find_last_ticket()[0]['bx_ticket_id'] . "\n" . $this->find_last_ticket()[0]['subject'] . "\n" . "\n" . $ticket_desk . "\n" .  "\n" . 'Документов добавлено ' . $count_media .  "\n" .  "\n" . '________' . "\n" . $link_bot;
    $media_box[0]['caption'] = $cap_text;
    return  $media_box;
  }
  public function packed_document_posting()
  {
    $media_box = [];
    $upd_media_box = [];
    $search_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'document')->limit(10)->get();
    $count_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'document')->limit(10)->count();
    foreach ($search_media as $media_item) {
      $media_box[] = ['type' => 'document', 'media' => $media_item->media_uuid, 'caption' => ''];
    }
    $link_bot = "⚙️ Для отправки обращения перейдите в @chmarkbot_bot";
    $ticket_desk  = Str::substr($this->find_last_ticket()[0]['description'], 0, 900);
    $cap_text = '❗️ Открыто новое обращение №' . $this->find_last_ticket()[0]['bx_ticket_id'] . "\n" . $this->find_last_ticket()[0]['subject'] . "\n" . "\n" . $ticket_desk . "\n" .  "\n" . '________' . "\n" . $link_bot;
    $media_box[$count_media - 1]['caption'] = $cap_text;
    return $media_box;
  }
  public function check_mime_file()
  {
    $search_media = TicketMedia::where('ticket_id', '=', $this->find_last_ticket()[0]['id'])->where('mime_type', '=', 'photo')->limit(10)->get();
    return $search_media;
  }
  public function check_token_ticket()
  {
    $user = $this->botman->getUser();
    $id_user = $user->getId();
    $search_token = DB::table('tg_token_session')->where('user_id', '=', $id_user)->exists();
    return $search_token;
  }
}
