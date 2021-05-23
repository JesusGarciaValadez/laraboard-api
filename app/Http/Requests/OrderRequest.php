<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'job_post_id' => 'required|numeric|exists:job_posts,id',
            'discount_id' => 'exclude_if:discount_id,null|present|numeric|exists:discounts,id',
            'order_status_id' => 'required|present|numeric|exists:order_statuses,id',
            'billing_information' => 'exclude_if:billing_information,null|present|string',
            'amount' => 'required|numeric',
            'tax_percentage' => 'required|integer',
        ];
    }
}
