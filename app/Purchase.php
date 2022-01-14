<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use Uuids;

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
        'user_id',
        'payment_mode_id',
        'purchaseNO',
        'qty',
        'price',
        'paid',
    ];

    /**
     * Get the sales here
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the credits here
     * @return HasMany
     */
    public function credit()
    {
        return $this->hasMany(Credit::class);
    }

    /**
     * Get the user here
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment mode
     * @return BelongsTo
     */
    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
