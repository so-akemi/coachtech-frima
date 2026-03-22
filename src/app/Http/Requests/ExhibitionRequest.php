<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image'       => ['required', 'image', 'mimes:jpeg,png'],
            'categories'  => ['required', 'array'],
            'condition'   => ['required', 'string'],
            'price'       => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'        => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max'      => '説明は255文字以内で入力してください',
            'image.required'       => '商品画像をアップロードしてください',
            'image.mimes'          => '画像は .jpeg または .png 形式でアップロードしてください',
            'categories.required'  => 'カテゴリーを選択してください',
            'condition.required'   => '商品の状態を選択してください',
            'price.required'       => '販売価格を入力してください',
            'price.integer'        => '数値で入力してください',
            'price.min'            => '0円以上の金額を入力してください',
        ];
    }
}