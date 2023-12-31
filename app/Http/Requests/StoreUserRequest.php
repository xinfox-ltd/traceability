<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'integer',
            'enterprise_id' => 'required',
            'name' => 'required',
            'username' => 'required',
            'phone' => ['required', Rule::unique('users')->ignore($this->request->get('id'))],
            'password' => 'required',
        ];
    }
}
