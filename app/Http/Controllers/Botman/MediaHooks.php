<?php

namespace App\Http\Controllers\Botman;

use App\Http\Controllers\Controller;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use App\Conversations\StartConversation;
use App\Bitrix24\Bitrix24API;
use Illuminate\Support\Str;
use App\Http\Controllers\FindClientDB;
use App\Models\TicketMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaHooks extends Controller
{
    public function parse_image($bot, $images)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $last_ticket = new FindClientDB();
                if (empty($last_ticket->find_client())) {
                    $bot->startConversation(new StartConversation);
                } else {
                    if (empty($last_ticket->check_token_ticket())) {
                        $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
                            ->oneTimeKeyboard(true)
                            ->resizeKeyboard(true)
                            ->addRow(
                                KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
                            )
                            ->toArray();
                        $bot->reply('Фотография не отправлена. Необходимо нажать кнопку «Начать ввод обращения» и в процессе создания обращения добавить фотографии.', $keyboard);
                    } else {
                        $webhookURL = 'https://ray.bitrix24.ru/rest/31/vb6oq13y3835i7p8/';
                        $bx24 = new Bitrix24API($webhookURL);
                        foreach ($images as $image) {
                            $filename = Str::random(10) . '.jpg';
                            $url = $image->getUrl(); // The direct url

                            $start_picture = $bx24->uploadfileDiskFolder(
                                $filderId = 557,
                                $rawFile = file_get_contents($url),
                                ['NAME' => $filename],
                                $isBase64FileData = false
                            );
                            $save_media = file_get_contents($url);
                            Storage::disk('images')->put($last_ticket->find_last_ticket()[0]['client_id'] . '/photo' . '/' . $filename, $save_media);
                            TicketMedia::insert(array(
                                'bx_id_file' => $start_picture['ID'],
                                'ticket_id' => $last_ticket->find_last_ticket()[0]['id'],
                                'mime_type' => 'photo',
                                'file_name' => $filename,
                                'file_path' => $last_ticket->find_last_ticket()[0]['client_id'] . '/photo' . '/' . $filename,
                                'media_uuid' => $image->getPayload()['file_id']
                            ));
                        }
                    }
                }
            }
        }
    }
    public function parse_document($bot, $files)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $last_ticket = new FindClientDB();
                if (empty($last_ticket->find_client())) {
                    $bot->startConversation(new StartConversation);
                } else {
                    if (empty($last_ticket->check_token_ticket())) {
                        $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
                            ->oneTimeKeyboard(true)
                            ->resizeKeyboard(true)
                            ->addRow(
                                KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
                            )
                            ->toArray();
                        $bot->reply('Документ не отправлен. Необходимо нажать кнопку «Начать ввод обращения» и в процессе создания обращения добавить документ.', $keyboard);
                    } else {
                        $webhookURL = 'https://ray.bitrix24.ru/rest/31/vb6oq13y3835i7p8/';
                        $bx24 = new Bitrix24API($webhookURL);
                        foreach ($files as $file) {
                            $url = $file->getUrl(); // The direct url
                            $start_picture = $bx24->uploadfileDiskFolder(
                                $filderId = 557,
                                $rawFile = file_get_contents($url),
                                ['NAME' => $file->getPayload()['file_name']],
                                $isBase64FileData = false,
                            );

                            $save_media = file_get_contents($url);
                            Storage::disk('images')->put($last_ticket->find_last_ticket()[0]['client_id'] . '/document' . '/' . $file->getPayload()['file_name'], $save_media);
                            TicketMedia::insert(array(
                                'bx_id_file' => $start_picture['ID'],
                                'ticket_id' => $last_ticket->find_last_ticket()[0]['id'],
                                'mime_type' => 'document',
                                'file_name' => $file->getPayload()['file_name'],
                                'file_path' => $last_ticket->find_last_ticket()[0]['client_id'] . '/document' . '/' . $file->getPayload()['file_name'],
                                'media_uuid' => $file->getPayload()['file_id']
                            ));
                        }
                    }
                }
            }
        }
    }
}
