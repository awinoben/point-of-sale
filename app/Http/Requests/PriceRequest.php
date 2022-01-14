<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed itemName
 */
class PriceRequest extends FormRequest
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
            'itemName' => ['required', 'string', 'max:255', 'unique:prices'],
            'itemPrice' => ['required', 'numeric'],
            'itemBPrice' => ['required', 'numeric'],
        ];
    }
}
