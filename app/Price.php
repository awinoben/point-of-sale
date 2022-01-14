<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Price extends Model
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
        'itemName',
        'itemPrice',
        'itemBPrice',
        'lowest'
    ];

    /**
     * Get the stock
     * @return HasMany
     */
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * get the supply here
     * @return HasMany
     */
    public function supply()
    {
        return $this->hasMany(Supply::class);
    }

    /**
     * get the sales
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
