<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Support\Collection;

/**
 * Class Discount
 * @package App\Models
 * @property User $createdBy
 * @property User $updatedBy
 * @property string $name
 * @property string|null $description
 * @property string $catalog_code
 * @property string short_code
 * @property float $amount
 * @property string $percentage
 * @property boolean $is_unique
 * @property boolean $is_manual
 * @property boolean $is_redeemed
 * @property Collection $invoices
 */
class Discount extends Model
{
    use HasFactory;

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
        'is_manual' => 'boolean',
        'is_active' => 'boolean',
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
        'is_reedemed',
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
}
