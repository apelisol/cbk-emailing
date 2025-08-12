<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'email_job_id',
        'type',
        'subject',
        'content',
        'status',
        'error',
        'sent_at',
        'recipient_email',
        'recipient_name',
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

    /**
     * Get the user that owns the sent email.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client that the email was sent to.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the email job that this sent email belongs to.
     */
    public function emailJob(): BelongsTo
    {
        return $this->belongsTo(EmailJob::class);
    }

    /**
     * Scope a query to only include direct emails.
     */
    public function scopeDirect($query)
    {
        return $query->where('type', self::TYPE_DIRECT);
    }

    /**
     * Scope a query to only include campaign emails.
     */
    public function scopeCampaign($query)
    {
        return $query->where('type', self::TYPE_CAMPAIGN);
    }

    /**
     * Scope a query to only include emails for the authenticated user.
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
}