<?php

namespace App\Models;

use Database\Factories\InvoiceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Invoice
 *
 * @package App\Models
 * @property Invoice $order
 * @property Discount|null $discount
 * @property User $createdBy
 * @property User $updatedBy
 * @property InvoiceStatus $status
 * @property int $id
 * @property int $order_id
 * @property int|null $discount_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $invoice_status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static InvoiceFactory factory(...$parameters)
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereCreatedBy($value)
 * @method static Builder|Invoice whereDiscountId($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceStatusId($value)
 * @method static Builder|Invoice whereOrderId($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereUpdatedBy($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Invoice onlyTrashed()
 * @method static Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Invoice withoutTrashed()
 */
class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const INVOICE_STATUS_CREATED = 'created';
    public const INVOICE_STATUS_CANCELLED = 'cancelled';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'discount_id',
        'created_by',
        'updated_by',
        'invoice_status_id',
    ];

    /**
     * An Invoice belongs to an Order
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * An Invoice has one Discount
     *
     * @return BelongsTo
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * An Invoice was created by a User
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * An Invoice was updated by a User
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * An Invoice has one Invoice Status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }
}
