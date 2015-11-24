<?php
namespace Celebgramme\Http\Requests;

use Celebgramme\Http\Requests\Request;

class ImageRequest extends Request
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
		$images = Request::file('meta_value');
        foreach( $images as $key => $val){
			$rules['meta_value.'.$key] = 'image';
		}
		return $rules;
    }
}
