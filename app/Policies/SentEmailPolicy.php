<?php
namespace App\Policies;

use App\Models\SentEmail;
use App\Models\User;

class SentEmailPolicy
{
    public function view(User $user, SentEmail $sentEmail): bool
    {
        return $user->id === $sentEmail->user_id;
    }
}
