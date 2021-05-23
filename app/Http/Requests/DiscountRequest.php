<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'exclude_if:description,null|present|string',
            'catalog_code' => 'required|string',
            'short_code' => 'required|string',
            'amount' => 'exclude_if:amount,null|required_if:percentage,null|present|numeric',
            'percentage' => 'exclude_if:percentage,null|required_if:amount,null|present|integer',
            'is_unique' => 'required|boolean',
            'is_manual' => 'required|boolean',
            'is_redeemed' => 'required|boolean',
            'is_active' => 'exclude_if:is_active,null|present|boolean',
            'go_live_date' => 'required|date',
            'due_date' => 'exclude_if:due_date,null|present|date',
        ];
    }
}
