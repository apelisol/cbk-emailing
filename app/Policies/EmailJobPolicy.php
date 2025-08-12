<?php
namespace App\Policies;

use App\Models\EmailJob;
use App\Models\User;

class EmailJobPolicy
{
    public function view(User $user, EmailJob $emailJob): bool
    {
        return $user->id === $emailJob->user_id;
    }

    public function delete(User $user, EmailJob $emailJob): bool
    {
        return $user->id === $emailJob->user_id;
    }
}