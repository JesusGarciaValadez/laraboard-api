<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class OrderStatus
 * @package App\Models
 * @property string $name
 * @property string|null $description
 * @property Collection $Orders
 */
class OrderStatus extends Model
{
    use HasFactory;

    public const OPEN = 'open';
    public const PAID = 'paid';
    public const ACTIVE = 'active';
    public const UNPAID = 'unpaid';
    public const INACTIVE = 'inactive';
    public const PAUSED = 'paused';
    public const CLOSED = 'closed';
    public const CANCELLED = 'cancelled';
    public const REFUNDED = 'refunded';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return Collection
     */
    public function getStatusesAttribute(): Collection
    {
        return collect([
            self::OPEN,
            self::PAID,
            self::ACTIVE,
            self::UNPAID,
            self::INACTIVE,
            self::PAUSED,
            self::CLOSED,
            self::CANCELLED,
            self::REFUNDED,
        ]);
    }

    /**
     * An Order Status can be set in many Orders
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
