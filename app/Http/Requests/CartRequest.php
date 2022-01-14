<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed price_id
 * @property mixed itemName
 * @property mixed qty
 * @property mixed price
 */
class CartRequest extends FormRequest
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
            'qty' => ['required', 'numeric'],
            'itemName' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ];
    }
}
