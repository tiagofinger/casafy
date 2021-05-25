<?php

namespace App\Http\Requests;

use App\MyLibrary\Interfaces\MyUserRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest implements MyUserRequest
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
            'name' => 'required|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->user),
                'email',
                'max:255'
            ],
        ];
    }
}
