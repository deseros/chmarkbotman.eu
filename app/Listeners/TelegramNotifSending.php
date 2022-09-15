<?php

namespace App\Listeners;

use App\Events\BotCompleteSending;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Http\Controllers\FindClientDB;

class TelegramNotifSending
{
    public $event;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle(BotCompleteSending $event)
    {
        $data_notif = (array) $event;

        $find = new FindClientDB();
        $client = new Client();

        /*$upd_ticket->tg_channel_msg_id = json_decode($res->getBody(),true)['result']['message_id'];
        $upd_ticket->save();*/
        if (!empty($find->packed_photo_posting()[0]['media']) and empty($find->packed_document_posting()[0]['media'])) {
            $res = $client->request(
                'POST',
                'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMediaGroup',
                [
                    'form_params' => [
                        'chat_id' => $find->find_client()['channel_chat_id'],
                        'media' => json_encode($find->packed_photo_posting()),
                    ]
                ]
            );
            //$upd_ticket->tg_channel_msg_id = json_decode($res->getBody(),true)['result'][0]['message_id'];
            //$upd_ticket->save();
        } else if (!empty($find->packed_document_posting()[0]['media']) and empty($find->packed_photo_posting()[0]['media'])) {
            $res = $client->request(
                'POST',
                'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMediaGroup',
                [
                    'form_params' => [
                        'chat_id' => $find->find_client()['channel_chat_id'],
                        'media' => json_encode($find->packed_document_posting()),
                    ]
                ]
            );
            //$upd_ticket->tg_channel_msg_id = json_decode($res->getBody(),true)['result'][0]['message_id'];
            //$upd_ticket->save();
        } else if (!empty($find->packed_document_posting()[0]['media']) and !empty($find->packed_photo_posting()[0]['media'])) {
            $res = $client->request(
                'POST',
                'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMediaGroup',
                [
                    'form_params' => [
                        'chat_id' => $find->find_client()['channel_chat_id'],
                        'media' => json_encode($find->packed_all_posting()),
                    ]
                ]
            );
            //$upd_ticket->tg_channel_msg_id = json_decode($res->getBody(),true)['result'][0]['message_id'];
            //$upd_ticket->save();
        } else {
            $link_bot = "⚙️ Для отправки обращения перейдите в @chmarkbot_bot";
            $res = $client->request('POST', 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'form_params' => [
                    'chat_id' => $data_notif['data']['chat_id'],
                    'text' => '❗️ Открыто новое обращение №' . $data_notif['data']['id'] . "\n" . $data_notif['data']['title'] . "\n" . "\n" . $data_notif['data']['description'] . "\n" . '___________' . "\n" . $link_bot,
                    'parse_mode' => 'HTML',
                ]
            ]);
            //$upd_ticket->tg_channel_msg_id = json_decode($res->getBody(),true)['result']['message_id'];
            //$upd_ticket->save();
        }
    }
}
