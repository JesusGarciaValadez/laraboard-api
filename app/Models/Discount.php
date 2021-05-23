<?php

namespace App\Models;

use Database\Factories\DiscountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Discount
 *
 * @package App\Models
 * @property User $createdBy
 * @property User $updatedBy
 * @property string $name
 * @property string|null $description
 * @property string $catalog_code
 * @property float $amount
 * @property string $percentage
 * @property boolean $is_unique
 * @property boolean $is_manual
 * @property boolean $is_redeemed
 * @property Collection $invoices
 * @property int $id
 * @property int $created_by
 * @property int $updated_by
 * @property string $short_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $invoices_count
 * @method static DiscountFactory factory(...$parameters)
 * @method static Builder|Discount newModelQuery()
 * @method static Builder|Discount newQuery()
 * @method static Builder|Discount query()
 * @method static Builder|Discount whereAmount($value)
 * @method static Builder|Discount whereCatalogCode($value)
 * @method static Builder|Discount whereCreatedAt($value)
 * @method static Builder|Discount whereCreatedBy($value)
 * @method static Builder|Discount whereDescription($value)
 * @method static Builder|Discount whereId($value)
 * @method static Builder|Discount whereIsManual($value)
 * @method static Builder|Discount whereIsRedeemed($value)
 * @method static Builder|Discount whereIsUnique($value)
 * @method static Builder|Discount whereName($value)
 * @method static Builder|Discount wherePercentage($value)
 * @method static Builder|Discount whereShortCode($value)
 * @method static Builder|Discount whereUpdatedAt($value)
 * @method static Builder|Discount whereUpdatedBy($value)
 * @mixin Eloquent
 * @property \datetime $go_live_date
 * @property \datetime|null $due_date
 * @property bool $is_active
 * @property Carbon|null $deleted_at
 * @property-read bool $is_live
 * @method static \Illuminate\Database\Query\Builder|Discount onlyTrashed()
 * @method static Builder|Discount whereDeletedAt($value)
 * @method static Builder|Discount whereDueDate($value)
 * @method static Builder|Discount whereGoLiveDate($value)
 * @method static Builder|Discount whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|Discount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Discount withoutTrashed()
 */
class Discount extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discounts';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
        'is_unique' => 'boolean',
        'is_manual' => 'boolean',
        'is_redeemed' => 'boolean',
        'is_active' => 'boolean',
        'go_live_date' => 'datetime:Y-m-d',
        'due_date' => 'datetime:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'name',
        'description',
        'catalog_code',
        'short_code',
        'amount',
        'percentage',
        'is_unique',
        'is_manual',
        'is_redeemed',
        'is_active',
        'go_live_date',
        'due_date',
    ];

    /**
     * A Discount can be set in many invoices
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * A Discount was created by a User
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * A Discount was updated by a User
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * A Discount is live
     *
     * @return bool
     */
    public function getIsLiveAttribute(): bool
    {
        return $this->go_live_date->isPast();
    }
}
