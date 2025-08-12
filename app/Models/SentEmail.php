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
        'content',
        'status',
        'error',
        'sent_at',
        'email_job_id',
        'client_id',
        'user_id',
        'type',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * The possible status values for sent emails.
     *
     * @var array
     */
    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';

    /**
     * The possible types of sent emails.
     *
     * @var array
     */
    const TYPE_CAMPAIGN = 'campaign';
    const TYPE_DIRECT = 'direct';

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