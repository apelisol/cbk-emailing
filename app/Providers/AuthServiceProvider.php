<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Client;
use App\Models\EmailJob;
use App\Models\EmailTemplate;
use App\Models\SentEmail;
use App\Policies\ClientPolicy;
use App\Policies\EmailJobPolicy;
use App\Policies\EmailTemplatePolicy;
use App\Policies\SentEmailPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        EmailTemplate::class => EmailTemplatePolicy::class,
        EmailJob::class => EmailJobPolicy::class,
        SentEmail::class => SentEmailPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}