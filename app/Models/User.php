<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Collection\Collection;

/**
 * Class User
 * @package App\Models
 * @property Role $role_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property array $metadata
 * @property string $remember_token
 * @property Carbon $email_verified_at
 * @property Role $role
 * @property Collection $jobPosts
 * @property Collection $orders
 * @property Collection $invoices
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const METADATA_PERIODICITY = 'periodicity';
    public const METADATA_PERIODICITY_DAILY = 'daily';
    public const METADATA_PERIODICITY_WEEKLY = 'weekly';
    public const METADATA_PERIODICITY_MONTHLY = 'monthly';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'metadata',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * A User only can have one Role
     *
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * A User can create many Job Posts
     *
     * @return HasMany
     */
    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class, 'created_by');
    }

    /**
     * A User can create many Orders
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    /**
     * A User can have many Invoices
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }
}
