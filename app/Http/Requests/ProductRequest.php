<?php
namespace Celebgramme\Http\Requests;

use Celebgramme\Http\Requests\Request;

class ProductRequest extends Request
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
            'product_name' => 'required',
            'product_price' => 'numeric',
            'product_stock' => 'numeric',
            'product_image' => 'image'
        ];
    }
}
