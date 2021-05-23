<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Order
 *
 * @package App\Models
 * @property JobPost $jobPost
 * @property Discount|null $discount
 * @property User $createdBy
 * @property User $updatedBy
 * @property OrderStatus $status
 * @property string|null $billingInformation
 * @property float $amount
 * @property int $tax_percentage
 * @property int $id
 * @property int $job_post_id
 * @property int|null $discount_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $order_status_id
 * @property string|null $billing_information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static OrderFactory factory(...$parameters)
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAmount($value)
 * @method static Builder|Invoice whereBillingInformation($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereCreatedBy($value)
 * @method static Builder|Invoice whereDiscountId($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereJobPostId($value)
 * @method static Builder|Invoice whereOrderStatusId($value)
 * @method static Builder|Invoice whereTaxPercentage($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereUpdatedBy($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 */
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_post_id',
        'discount_id',
        'created_by',
        'updated_by',
        'order_status_id',
        'billing_information',
        'amount',
        'tax_percentage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
    ];

    /**
     * An Order has one Job Post
     *
     * @return BelongsTo
     */
    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    /**
     * An Order has one Discount
     *
     * @return BelongsTo
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * An Order belongs to a User that created it
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * An Order belongs to a User that updated it
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * An Order has one Order Status
     *
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }
}
