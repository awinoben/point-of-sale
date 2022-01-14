<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed payment_mode_id
 */
class CreditPurchaseRequest extends FormRequest
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
            'payment_mode_id' => ['required'],
            'name' => ['required'],
            'phoneNumber' => ['required', 'digits_between:10,10', 'numeric'],
        ];
    }
}