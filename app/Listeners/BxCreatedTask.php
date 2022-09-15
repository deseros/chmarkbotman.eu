<?php

namespace App\Listeners;

use App\Events\EventBitrixAddTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;
use App\Models\Ticket;
use App\Http\Controllers\FindClientDB;

class BxCreatedTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EventBitrixAddTask  $event
     * @return void
     */
    public function handle(EventBitrixAddTask $event)
    {

        $data_bx = (array) $event;

        $bx24 = new Bitrix24API(env("BX_WEBHOOK"));
        $finder = new FindClientDB();
        $data_send = $bx24->addTask([
            'TITLE'           => $data_bx["data_task"][0]["task_title"], // Название задачи
            'RESPONSIBLE_ID'  => 25, // ID ответственного пользователя
            'DESCRIPTION' => $data_bx["data_task"][0]["task_description"],
            'START_DATE_PLAN' => date('Y/m/d H:i:s'), // Плановая дата начала.
            'CREATED_BY' => $data_bx["data_task"][0]["created"],
            'GROUP_ID' => $data_bx["data_task"][0]["id_group"],
        ]);
        if (!empty($finder->find_media_last_ticket())) {
            $bx24->updTask(
                $data_send['task']['id'],
                ['UF_TASK_WEBDAV_FILES'  => $finder->find_media_last_ticket()]
            );
        }
        $upd_ticket = Ticket::find($finder->find_last_ticket()[0]['id']);
        $upd_ticket->bx_ticket_id = $data_send['task']['id'];
        $upd_ticket->save();
        return $data_send;
    }
}
