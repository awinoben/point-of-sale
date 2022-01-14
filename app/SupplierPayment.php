<?php

namespace App;

use App\Uuids\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierPayment extends Model
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
        'supplier_arrear_id',
        'invoiceNumber',
        'amount',
    ];

    /**
     * Get the supplier arrear id here
     * @return BelongsTo
     */
    public function supplier_arrear()
    {
        return $this->belongsTo(SupplierArrear::class);
    }

    /**
     * Get the user who did transaction
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
