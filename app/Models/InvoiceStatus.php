<?php

namespace App\Models;

use Database\Factories\InvoiceStatusFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class InvoiceStatus
 *
 * @package App\Models
 * @property string $name
 * @property string|null $description
 * @property Collection $invoices
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $invoices_count
 * @method static InvoiceStatusFactory factory(...$parameters)
 * @method static Builder|InvoiceStatus newModelQuery()
 * @method static Builder|InvoiceStatus newQuery()
 * @method static Builder|InvoiceStatus query()
 * @method static Builder|InvoiceStatus whereCreatedAt($value)
 * @method static Builder|InvoiceStatus whereDescription($value)
 * @method static Builder|InvoiceStatus whereId($value)
 * @method static Builder|InvoiceStatus whereName($value)
 * @method static Builder|InvoiceStatus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class InvoiceStatus extends Model
{
    use HasFactory;

    public const CREATED = 'created';
    public const CANCELLED = 'cancelled';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_statuses';

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
     * An Invoice Status can be set in many Invoices
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
