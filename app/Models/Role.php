<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Ramsey\Collection\Collection;

/**
 * Class Role
 *
 * @package App\Models
 * @property string $name
 * @property string|null $description
 * @property Collection $users
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $users_count
 * @method static RoleFactory factory(...$parameters)
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $deleted_at
 * @method static Builder|Role whereDeletedAt($value)
 */
class Role extends Model
{
    use HasFactory;

    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const JOBPOSTER = 'jobposter';
    public const JOBSEEKER = 'jobseeker';

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
     * A sole Role can be in many Users
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
