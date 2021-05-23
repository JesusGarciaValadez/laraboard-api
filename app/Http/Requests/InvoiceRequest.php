<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'order_id' => 'required|numeric|exists:App\Models\Order,id',
            'discount_id' => 'exclude_if:discount_id,null|numeric|exists:App\Models\Discount,id',
            'invoice_status_id' => 'required|numeric|exists:App\Models\InvoiceStatus,id',
        ];
    }
}
