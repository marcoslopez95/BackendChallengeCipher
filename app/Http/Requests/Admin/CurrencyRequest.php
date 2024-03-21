<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'name' => 'required|string|unique:currencies,name',
            'abbreviation' => 'required|string',
            'symbol' => 'required|string',
            'exchange' => 'required|numeric|min:0',
            'principal' => 'required|boolean',
        ];
        if($this->isMethod('PUT')){
            $rules['name'] .= ','.$this->currency->id;
        }
        return $rules;
    }
}
