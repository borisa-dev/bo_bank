<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'name'          => 'string|max:255',
            'email'         => 'email:rfc,dns|unique:users,email,' . $userId,
            'date_of_birth' => [
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],
        ];
    }
}
