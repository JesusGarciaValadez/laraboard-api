<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class JobPost
 * @package App\Models
 * @property Order|null $order
 * @property User $createdBy
 * @property User $updatedBy
 * @property array $countries
 * @property string $title
 * @property string|null $description
 * @property bool $is_remote
 * @property string $url
 * @property array|null $tags
 * @property string|null $logo_url
 * @property array|null $enhancements
 * @property Carbon $go_live_date
 * @property Carbon|null $due_date
 * @property boolean $is_active
 * @property boolean $isLive
 */
class JobPost extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'created_by',
        'updated_by',
        'countries',
        'title',
        'description',
        'is_remote',
        'url',
        'tags',
        'logo_url',
        'enhancements',
        'go_live_date',
        'due_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'countries' => 'array',
        'is_remote' => 'boolean',
        'tags' => 'array',
        'enhancements' => 'array',
        'go_live_date' => 'datetime',
        'due_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * A Job Post has one Order
     *
     * @return BelongsTo
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /**
     * A Job Post belongs to a User that created it
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * A Job Post belongs to a User that updated it
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * A Job Post is live
     *
     * @return bool
     */
    public function getIsLiveAttribute(): bool
    {
        return $this->go_live_date->isPast();
    }
}
