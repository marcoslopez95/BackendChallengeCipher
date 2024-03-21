<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!auth()->user()->roles->where('id',Role::ADMIN)->first();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|unique:products,name',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image',
        ];

        if($this->isMethod('PUT'))
        {
            $rules['name'] .= ',' . $this->product->id;
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }
}
