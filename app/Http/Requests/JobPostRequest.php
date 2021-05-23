<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
            'countries' => 'required|json',
            'company' => 'required|string',
            'title' => 'required|string',
            'description' => 'exclude_if:description,null|present|string',
            'is_remote' => 'required|boolean',
            'url' => 'required|url',
            'tags' => 'exclude_if:tags,null|present|json',
            'logo' => 'exclude_if:logo,null|present|image',
            'enhancements' => 'exclude_if:enhancements,null|present|json',
            'go_live_date' => 'required|date',
            'due_date' => 'exclude_if:due_date,null|present|date',
            'is_active' => 'required|boolean',
        ];
    }
}
