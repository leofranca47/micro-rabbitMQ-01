<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCompanyRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', "unique:companies,name,{$this->segment(2)},url"],
            'whatsapp' => ['required','unique:companies'],
            'email' => ['required', 'unique:companies', 'email'],
            'phone' => ['nullable', 'unique:companies'],
            'facebook' => ['nullable', 'unique:companies'],
            'instagram' => ['nullable', 'unique:companies'],
            'youtube' => ['nullable', 'unique:companies'],
        ];
    }
}
