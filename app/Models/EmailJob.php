<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'body',
        'recipient_ids',
        'type',
        'template_id',
        'scheduled_at',
        'status',
        'user_id',
    ];

    protected $casts = [
        'recipient_ids' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function sentEmails(): HasMany
    {
        return $this->hasMany(SentEmail::class);
    }

    public function recipients()
    {
        return Client::whereIn('id', $this->recipient_ids ?? []);
    }
}