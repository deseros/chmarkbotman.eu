<?php

namespace App\Listeners;

use App\Events\EventBitrixAddTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;

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
      
        $data_send = $bx24->addTask( [
            'TITLE'           => $data_bx["data_task"][0]["task_title"], // Название задачи
            'RESPONSIBLE_ID'  => 25, // ID ответственного пользователя
            'DESCRIPTION' => $data_bx["data_task"][0]["task_description"],
            'START_DATE_PLAN' => date( 'Y/m/d H:i:s'), // Плановая дата начала.
            'CREATED_BY' =>$data_bx["data_task"][0]["created"],
            'GROUP_ID' => $data_bx["data_task"][0]["id_group"],
        ]); 
        return $data_send;

    }
}
