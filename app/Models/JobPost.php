<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Database\Factories\JobPostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class JobPost
 *
 * @package App\Models
 * @property Invoice|null $order
 * @property User $createdBy
 * @property User $updatedBy
 * @property array $countries
 * @property string $company
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
 * @property int $id
 * @property int|null $order_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read bool $is_live
 * @method static JobPostFactory factory(...$parameters)
 * @method static Builder|JobPost newModelQuery()
 * @method static Builder|JobPost newQuery()
 * @method static Builder|JobPost query()
 * @method static Builder|JobPost whereCountries($value)
 * @method static Builder|JobPost whereCreatedAt($value)
 * @method static Builder|JobPost whereCreatedBy($value)
 * @method static Builder|JobPost whereDescription($value)
 * @method static Builder|JobPost whereDueDate($value)
 * @method static Builder|JobPost whereEnhancements($value)
 * @method static Builder|JobPost whereGoLiveDate($value)
 * @method static Builder|JobPost whereId($value)
 * @method static Builder|JobPost whereIsActive($value)
 * @method static Builder|JobPost whereIsRemote($value)
 * @method static Builder|JobPost whereLogoUrl($value)
 * @method static Builder|JobPost whereOrderId($value)
 * @method static Builder|JobPost whereTags($value)
 * @method static Builder|JobPost whereTitle($value)
 * @method static Builder|JobPost whereUpdatedAt($value)
 * @method static Builder|JobPost whereUpdatedBy($value)
 * @method static Builder|JobPost whereUrl($value)
 * @method static Builder|JobPost whereCompany($value)
 * @mixin Eloquent
 * @property string|null $deleted_at
 * @method static Builder|JobPost whereDeletedAt($value)
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
        'company',
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
        'go_live_date' => 'datetime:Y-m-d',
        'due_date' => 'datetime:Y-m-d',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_live'];

    /**
     * A Job Post has one Order
     *
     * @return HasOne
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
