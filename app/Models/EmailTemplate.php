<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'body',
        'placeholders',
        'user_id',
    ];

    protected $casts = [
        'placeholders' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function emailJobs(): HasMany
    {
        return $this->hasMany(EmailJob::class, 'template_id');
    }

    public function replacePlaceholders(Client $client): array
    {
        $subject = str_replace(
            ['{{name}}', '{{email}}', '{{phone}}'],
            [$client->name, $client->email, $client->phone ?? ''],
            $this->subject
        );

        $body = str_replace(
            ['{{name}}', '{{email}}', '{{phone}}'],
            [$client->name, $client->email, $client->phone ?? ''],
            $this->body
        );

        return compact('subject', 'body');
    }
}