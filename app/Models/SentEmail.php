<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_email',
        'recipient_name', 
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'email_job_id',
        'client_id',
        'user_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function emailJob(): BelongsTo
    {
        return $this->belongsTo(EmailJob::class);
    }
}