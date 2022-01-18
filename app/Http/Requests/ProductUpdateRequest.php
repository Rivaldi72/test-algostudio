<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
        $name = $this->request->get("name");
            return [
                'name'          => [
                        'nullable',
                        Rule::unique('products')->ignore($name,'name'),
                ],
                'description'   => 'nullable',
                'price'         => 'nullable|numeric',
                'image'         => 'nullable|mimes:jpeg,png',
                'category_id'   => 'nullable|exists:product_categories,id',
                'unit'          => 'nullable|numeric'
            ];
    }
}
