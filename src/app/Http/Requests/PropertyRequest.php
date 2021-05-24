<?php

namespace App\Http\Requests;

use App\MyLibrary\Interfaces\MyRequest;
use App\Rules\PurchasedIsNotPermittedIfFalseAndMoreThan;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest implements MyRequest
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
            'address' => 'required|max:255',
            'bedrooms' => 'required|integer|gte:0',
            'bathrooms' => 'required|integer|gte:0',
            'total_area' => 'required|integer|gte:0',
            'purchased' => [
                'required',
                'boolean',
                new PurchasedIsNotPermittedIfFalseAndMoreThan(
                    null,
                    (int)$this->request->all()['owner_id'],
                    3
                )
            ],
            'value' => 'required|numeric|gte:0',
            'discount' => 'required|integer|gte:0|lte:101',
            'owner_id' => [
                'required',
                'integer',
                'exists:App\Models\User,id'
            ],
            'expired' => 'required|boolean',
        ];
    }
}
