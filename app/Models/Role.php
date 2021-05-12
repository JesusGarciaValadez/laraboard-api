<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Collection\Collection;

/**
 * Class Role
 * @package App\Models
 * @property string $name
 * @property string|null $description
 * @property Collection $users
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
