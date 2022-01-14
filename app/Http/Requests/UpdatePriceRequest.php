<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed price_id
 * @property mixed itemName
 * @property mixed itemPrice
 * @property mixed itemBPrice
 * @property mixed lowest
 */
class UpdatePriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'price_id' => ['required'],
            'itemName' => ['required', 'string', 'max:255'],
            'itemPrice' => ['required', 'numeric'],
            'itemBPrice' => ['required', 'numeric'],
            'lowest' => ['required', 'integer']
        ];
    }
}
