<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed price_id
 * @property mixed itemBQuantity
 * @property mixed itemBPrice
 * @property mixed supplier_id
 * @property mixed payment
 */
class StockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price_id' => ['required'],
            'supplier_id' => ['required'],
            'itemBPrice' => ['required', 'numeric'],
            'payment' => ['required', 'numeric'],
            'itemBQuantity' => ['required', 'numeric'],
        ];
    }
}
