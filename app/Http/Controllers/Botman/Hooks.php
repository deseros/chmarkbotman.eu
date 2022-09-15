<?php

namespace App\Http\Controllers\Botman;

use App\Http\Controllers\Controller;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use App\Conversations\ExampleConversation;
use App\Conversations\StartConversation;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Http\Controllers\FindClientDB;
use App\Models\Ticket;
use App\Models\ClientTelegramId;
use Illuminate\Support\Facades\DB;
use App\Events\BotCompleteSending;
use App\Events\EventBitrixAddTask;

class Hooks extends Controller
{
    public function __construct()
    {
    }
    public function start($bot)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $user = $bot->getUser();
                $id = $user->getId();
                $info = $user->getInfo();
                $check_user = ClientTelegramId::where('telegram_id', '=', $id)->exists();
                if (!empty($check_user)) {
                    $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
                        ->oneTimeKeyboard(true)
                        ->resizeKeyboard(true)
                        ->addRow(
                            KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
                        )
                        ->toArray();
                    $bot->reply('Ваш ID уже добавлен в базу клиентов, бот запущен.', $keyboard);
                    $bot->reply('Создание обращения происходит в несколько этапов. Нажать кнопку «Начать ввод обращения», ввести тему, текст сообщения и отправить фотографий. Следуйте инструкциям бота.' . "\n" . "\n" . 'Если клавиатура не отобразилась необходимо нажать на значок клавиатуры 🎛');
                } else {
                    $bot->startConversation(new StartConversation);
                    $first_name = isset($info['user']['first_name']) ? $info['user']['first_name'] : 'имя скрыто';
                    $last_name = isset($info['user']['last_name']) ? $info['user']['last_name'] : 'фамилия скрыта';
                    $username = isset($info['user']['username']) ? $info['user']['username'] : 'имя пользователя скрыто';
                    $text = '❗️❗️❗️Внимание' . "\n" . 'Выполнен новый запуск бота пользователем' . "\n"
                        . '<b>Его имя </b>' . '  ' . $first_name . "\n"
                        . '<b>Его фамилия </b>' . '  ' . $last_name . "\n"
                        . '<b>Его имя пользователя</b>' . '  ' . '@' . $username . "\n"
                        . '<b>Его ID</b>' . '  ' . $id;
                    $client = new Client();
                    $res = $client->request(
                        'POST',
                        'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
                        [
                            'form_params' => [
                                'chat_id' => '834922187',
                                'text' => $text,
                                'parse_mode' => 'HTML',
                            ]
                        ]
                    );
                }
            }
        }
    }
    public function start_ticket($bot)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $last_ticket = new FindClientDB();
                if (empty($last_ticket->find_client())) {
                    $bot->startConversation(new StartConversation);
                } else {
                    $bot->startConversation(new ExampleConversation);
                }
            }
        }
    }
    public function complete_ticket($bot)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $last_ticket = new FindClientDB();
                if (empty($last_ticket->find_client())) {
                    $bot->startConversation(new StartConversation);
                } else {
                    $channel_link = Keyboard::create()->type(Keyboard::TYPE_INLINE)
                        ->addRow(
                            KeyboardButton::create("Перейти в канал обращений")->url($last_ticket->find_client()['invait_link_channel'])
                        )
                        ->toArray();
                    $bot->reply('Вы можете перейти в канал обращений или создать новое', $channel_link);
                    $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
                        ->oneTimeKeyboard(true)
                        ->resizeKeyboard(true)
                        ->addRow(
                            KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
                        )
                        ->toArray();
                    $bot->reply('Создание обращения происходит в несколько этапов. Нажать кнопку «Начать ввод обращения», ввести тему, текст сообщения и отправить фотографий. Следуйте инструкциям бота.' . "\n" . "\n" . 'Если клавиатура не отобразилась необходимо нажать на значок клавиатуры 🎛', $keyboard);
                    $data_task = array(
                        [
                            "task_title" => $last_ticket->find_last_ticket()[0]['subject'],
                            "task_description" => $last_ticket->find_last_ticket()[0]['description'],
                            "created" => $last_ticket->find_client()['bx_id_user'],
                            "id_group" => $last_ticket->find_client()['bx_id_group']
                        ]
                    );
                    $send_bx = EventBitrixAddTask::dispatch(collect($data_task));

                    if (!empty($last_ticket->find_client()['channel_chat_id'])) {
                        BotCompleteSending::dispatch(collect($send_bx[0]['task'])->only('id', 'title', 'description')->merge(["chat_id" => $last_ticket->find_client()['channel_chat_id']]));
                    }
                    $user = $bot->getUser();
                    $id_user = $user->getId();
                    DB::table('tg_token_session')->where('user_id', '=', $id_user)->delete();
                }
            }
        }
    }
    public function default($bot)
    {
        $check_status = $bot->getMessage()->getPayload();
        if (isset($check_status['chat'])) {
            if ($check_status['from']['id'] == $check_status['chat']['id']) {
                $last_ticket = new FindClientDB();
                if (empty($last_ticket->find_client())) {
                    $bot->startConversation(new StartConversation);
                } else {
                    $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
                        ->oneTimeKeyboard(true)
                        ->resizeKeyboard(true)
                        ->addRow(
                            KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
                        )
                        ->toArray();
                    $bot->reply('Создание обращения происходит в несколько этапов. Нажать кнопку «Начать ввод обращения», ввести тему, текст сообщения и отправить фотографий. Следуйте инструкциям бота.' . "\n" . "\n" . 'Если клавиатура не отобразилась необходимо нажать на значок клавиатуры 🎛', $keyboard);
                }
            }
        }
    }
}
