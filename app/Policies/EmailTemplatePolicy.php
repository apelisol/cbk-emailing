<?php
namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\User;

class EmailTemplatePolicy
{
    public function view(User $user, EmailTemplate $emailTemplate): bool
    {
        return $user->id === $emailTemplate->user_id;
    }

    public function update(User $user, EmailTemplate $emailTemplate): bool
    {
        return $user->id === $emailTemplate->user_id;
    }

    public function delete(User $user, EmailTemplate $emailTemplate): bool
    {
        return $user->id === $emailTemplate->user_id;
    }
}