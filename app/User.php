<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Note\Models\Notification;

class User extends Authenticatable
{
    use Notifiable, Uuids;

    /**
     * type of auto-increment
     *
     * @string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'pin',
        'salary',
        'admin',
        'superAdmin',
        'blocked',
        'password',
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
        'email_verified_at' => 'datetime',
    ];

    /**
     * get user notification
     * @return MorphMany
     */
    public function notification()
    {
        return $this->morphMany(Notification::class, 'notification');
    }

    /**
     * Get purchases
     * @return HasMany
     */
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get sales
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the payment id
     * @return HasMany
     */
    public function supplier_payment()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    /**
     * Get the credit payments
     * @return HasMany
     */
    public function credit_payment()
    {
        return $this->hasMany(CreditPayment::class);
    }
}
