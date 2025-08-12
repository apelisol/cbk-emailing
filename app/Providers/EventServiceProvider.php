<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\EmailSent::class => [
            \App\Listeners\UpdateEmailJobStatus::class,
        ],
    ];
}