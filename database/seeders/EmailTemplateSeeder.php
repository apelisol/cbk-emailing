<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        
        if ($user) {
            $templates = [
                [
                    'name' => 'Welcome Email',
                    'subject' => 'Welcome to CBK Email Automation, {{name}}!',
                    'body' => "Hello {{name}},\n\nWelcome to CBK Email Automation! We're excited to have you on board.\n\nIf you have any questions, please don't hesitate to reach out to us.\n\nBest regards,\nThe CBK Team",
                    'placeholders' => ['name'],
                ],
                [
                    'name' => 'Monthly Newsletter',
                    'subject' => 'Monthly Update for {{name}}',
                    'body' => "Hi {{name}},\n\nHere's your monthly update from CBK Email Automation.\n\n[Newsletter content goes here]\n\nContact us at {{email}} if you need assistance.\n\nBest regards,\nThe CBK Team",
                    'placeholders' => ['name', 'email'],
                ],
                [
                    'name' => 'Follow-up Email',
                    'subject' => 'Following up with {{name}}',
                    'body' => "Dear {{name}},\n\nI hope this email finds you well. I wanted to follow up on our previous conversation.\n\nPlease feel free to contact me at your convenience. You can reach me at {{phone}} or reply to this email.\n\nLooking forward to hearing from you.\n\nBest regards,\nThe CBK Team",
                    'placeholders' => ['name', 'phone'],
                ],
            ];

            foreach ($templates as $templateData) {
                $user->emailTemplates()->create($templateData);
            }
        }
    }
}
