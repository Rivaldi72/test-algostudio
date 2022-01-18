<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'          => 'required|max:255|unique:products,name',
                    'description'   => 'required',
                    'price'         => 'required|numeric',
                    'unit'          => 'required|numeric',
                    'image'         => 'required|mimes:jpeg,png',
                    'category_id'   => 'required|exists:product_categories,id',
                    'code'          => 'required'
                ];
                break;
        }
    }
}
