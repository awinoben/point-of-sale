<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
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
        'price_id',
        'SKU',
        'itemBQuantity',
        'itemSQuantity',
        'counter',
        'itemBPrice',
        'itemTBPrice',
        'itemTSBPrice',
        'itemRevenue',
        'past',
    ];

    /**
     * get the price
     * @return BelongsTo
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    /**
     * Get arrears here
     * @return HasOne
     */
    public function supplier_arrear()
    {
        return $this->hasOne(SupplierArrear::class);
    }

    /**
     * Get the sales here
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
