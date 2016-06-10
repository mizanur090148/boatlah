<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request
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
        if(! is_null(Request::get('country') ) )
        {
            $value = $this->checkField(Request::get('country'));
        }

        return [
            'country'           => $value
        ];
        
        return [
            'email' => 'required|email',
            //'mobile' => 'required'
        ];
    }
}
