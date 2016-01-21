<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePersonRequest extends Request
{
    protected $firstNameMinLength = 2;

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
        $firstNameMinLength = $this->firstNameMinLength;
        return [
            'first_name' => "required|min:{$firstNameMinLength}",
            'gender' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $firstNameMinLength = $this->firstNameMinLength;
        return [
            'first_name.required' => 'Поле имя обязательно для заполнения',
            'first_name.min' => "Поле должно быть длиннее {$firstNameMinLength}-х символов",
            'gender.required'  => 'Поле пол обязательно для заполнения',
        ];
    }
}
