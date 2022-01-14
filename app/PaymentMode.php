<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMode extends Model
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
        'mode',
    ];

    /**
     * get sales
     * @return HasMany
     */
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * get purchase
     * @return HasMany
     */
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
