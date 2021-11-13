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
            'name' => ['required', "unique:companies,name,{$this->company},uuid"],
            'whatsapp' => ['required',"unique:companies,whatsapp,{$this->company},uuid"],
            'email' => ['required', "unique:companies,email,{$this->company},uuid", 'email'],
            'phone' => ['nullable', "unique:companies,phone,{$this->company},uuid"],
            'facebook' => ['nullable', "unique:companies, facebook,{$this->company},uuid"],
            'instagram' => ['nullable', "unique:companies,instagram,{$this->company},uuid"],
            'youtube' => ['nullable', "unique:companies,youtube,{$this->company},uuid"],
        ];
    }
}
