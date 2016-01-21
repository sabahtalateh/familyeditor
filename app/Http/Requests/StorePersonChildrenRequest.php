<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePersonChildrenRequest extends Request
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
            'father' => 'required|exists:persons,id|different:child',
            'mother' => 'required|exists:persons,id|different:child',
            'child' => 'required|exists:persons,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'father.required' => 'Выберите Отца',
            'father.exists' => 'Нет такого человека для поля Отец',
            'father.different' => 'Поля Отец и Ребенок должны отличаться',
            'mother.required' => 'Выберите Мать',
            'mother.exists' => 'Нет такого человека для поля Мать',
            'mother.different' => 'Поля Мать и Ребенок должны отличаться',
            'child.required' => 'Выберите Ребенка',
            'child.exists' => 'Нет такого человека для поля Ребенок',
        ];
    }
}
