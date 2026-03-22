<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class profileupdaterequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'phone' => 'required|max:15|unique:users,phone,' . ($this->user() ? $this->user()->id : 'NULL'),
            'gender' => 'sometimes|max:50',
            'email' => 'required|email|unique:users,email,' . ($this->user() ? $this->user()->id : 'NULL'),
            'birth_date' => 'sometimes|date',
            'image' => ['sometimes', 'image', 'mimes:jpg,png,jpeg,webp', 'max:2048'],
        ];
    }
}
