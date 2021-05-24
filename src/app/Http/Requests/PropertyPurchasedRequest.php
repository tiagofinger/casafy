<?php

namespace App\Http\Requests;

use App\MyLibrary\Interfaces\MyRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PurchasedIsNotPermittedIfFalseAndMoreThan;

class PropertyPurchasedRequest extends FormRequest implements MyRequest
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
            'purchased' => [
                'required',
                'boolean',
                new PurchasedIsNotPermittedIfFalseAndMoreThan(
                    (int)$this->route('id'),
                    null,
                    3
                )
            ]
        ];
    }
}
