<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
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
        'stock_id',
        'purchase_id',
        'price_id',
        'payment_mode_id',
        'qty',
        'price',
        'total',
    ];

    /**
     * Get the payment mode
     * @return BelongsTo
     */
    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    /**
     * Get the purchase here
     * @return BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the stock here
     * @return BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
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
     * Get the price
     * @return BelongsTo
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }
}
