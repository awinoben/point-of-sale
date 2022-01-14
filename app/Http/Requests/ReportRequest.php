<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed type
 * @property mixed from_date
 * @property mixed to_date
 */
class ReportRequest extends FormRequest
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
            'type' => ['string', 'required'],
            'from_date' => ['date', 'required', 'before:tomorrow'],
            'to_date' => ['date', 'required', 'after_or_equal:from_date', 'before:tomorrow']
        ];
    }
}
