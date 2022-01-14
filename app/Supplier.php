<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
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
        'name',
        'phoneNumber',
        'email',
        'location',
    ];

    /**
     * get arrears here
     * @return HasMany
     */
    public function supplier_arrear(): HasMany
    {
        return $this->hasMany(SupplierArrear::class);
    }

    /**
     * get the supply here
     * @return HasMany
     */
    public function supply(): HasMany
    {
        return $this->hasMany(Supply::class);
    }
}
