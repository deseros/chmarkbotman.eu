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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FindClientDB;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\Ticket;
use Illuminate\Support\Str;
use App\Events\BotCompleteSending;
use App\Events\EventBitrixAddTask;

class ExampleConversation extends Conversation
{
    protected string $subject;

    protected string $body;

    protected object $botman;

    public function __construct(string $subject = '', string $body = '', object $botman  = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->botman = $botman = app('botman');
    }
    public function subject_ticket()
    {

        $this->ask('Введите тему обращения. (только текст 5-7 слов)', function (Answer $answer) {
            if ($answer->getText() == '%%%_FILE_%%%' or $answer->getText() == '%%%_IMAGE_%%%') {
                $this->say("Тема обращения может состоять из букв, цифр и знаков препинания, попробуйте еще раз");
                $this->subject_ticket();
            } else {
                $user = $this->botman->getUser();
                $id_user = $user->getId();
                DB::table('tg_token_session')->insert(
                    [
                        'token' => Str::random(10),
                        'user_id' => $id_user
                    ]
                );

                $this->subject = $answer->getText();
                if (iconv_strlen($this->subject) > 200) {
                    $this->say("Заголовок обращения может содержать не более 5-7 слов, попробуйте еще раз");
                    DB::table('tg_token_session')->where('user_id', '=', $id_user)->delete();
                    $this->subject_ticket();
                } else {
                    $this->body_ticket();
                }
            }
        });
    }

    public function body_ticket()
    {

        $this->ask('Опишите вашу проблему детально. (только текст)', function (Answer $answer) {
            if ($answer->getText() == '%%%_FILE_%%%' or $answer->getText() == '%%%_IMAGE_%%%') {
                $this->say("Подробное описание обращения может состоять из букв, цифр и знаков препинания, попробуйте еще раз");
                $this->body_ticket();
            } else {
                $this->body = $answer->getText();
                $main_user = new FindClientDB();
                $curr_user = $main_user->find_client()['id'];
                Ticket::insert(array(
                    'subject' => $this->subject,
                    'description' => $this->body,
                    'client_id' => $curr_user,
                    'created_at' => date('Y/m/d H:i:s')
                ));


                $this->send_media();
            }
        });
    }
    public function send_media()
    {
        $question = Question::create('Хотите добавить фотографии?')
            ->addButtons([
                Button::create('Да, хочу')->value('да'),
                Button::create('Нет, отправить без фото')->value('нет'),
            ]);

        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === "да") {
                    $this->askPhoto();
                } else {
                    $this->complete_ticket();
                }
            }
        });
    }

    public function askPhoto()
    {
        $keyboard = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
            ->oneTimeKeyboard(true)
            ->resizeKeyboard(true)
            ->addRow(
                KeyboardButton::create("Завершить отправку")->callbackData('first_inline')
            )
            ->toArray();
        $this->say("Добавляйте фотографии. ( максимум до 10 штук )", $keyboard);
    }
    public function complete_ticket()
    {

        $finder = new FindClientDB();
        $data_task = array(
            [
                "task_title" => $this->subject,
                "task_description" => $this->body,
                "created" => $finder->find_client()['bx_id_user'],
                "id_group" => $finder->find_client()['bx_id_group']
            ]
        );

        $send_bx = EventBitrixAddTask::dispatch(collect($data_task));

        $keyboard = Keyboard::create()->type(Keyboard::TYPE_INLINE)
            ->addRow(
                KeyboardButton::create("Перейти в канал обращений")->url($finder->find_client()['invait_link_channel'])
            )
            ->toArray();

        $this->say('Вы можете перейти в канал обращений или создать новое', $keyboard);
        if (!empty($finder->find_client()['channel_chat_id'])) {
            BotCompleteSending::dispatch(collect($send_bx[0]['task'])->only('id', 'title', 'description')->merge(["chat_id" => $finder->find_client()['channel_chat_id']]));
        }
        $keyboard_say = Keyboard::create()->type(Keyboard::TYPE_KEYBOARD)
            ->oneTimeKeyboard(true)
            ->resizeKeyboard(true)
            ->addRow(
                KeyboardButton::create("Начать ввод обращения")->callbackData('first_inline')
            )
            ->toArray();
        $this->say('Создание обращения происходит в несколько этапов. Нажать кнопку «Начать ввод обращения», ввести тему, текст сообщения и отправить фотографий. Следуйте инструкциям бота.', $keyboard_say);

        $user = $this->botman->getUser();
        $id_user = $user->getId();
        DB::table('tg_token_session')->where('user_id', '=', $id_user)->delete();
    }
    public function run()
    {
        // This will be called immediately
        $this->subject_ticket();
    }
}
