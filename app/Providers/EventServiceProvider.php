<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\BotCompleteSending;
use App\Events\EventBitrixAddTask;
use App\Listeners\BxCreatedTask;
use App\Listeners\TelegramNotifSending;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventBitrixAddTask::class =>[
            BxCreatedTask::class,
        ],
        BotCompleteSending::class => [
            TelegramNotifSending::class,     
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
