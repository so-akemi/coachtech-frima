<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            // 設計書: 拡張子が .jpeg もしくは .png
            'image'       => ['nullable', 'image', 'mimes:jpeg,png'],
            
            // 設計書: 入力必須、20文字以内
            'user_name'   => ['required', 'string', 'max:20'],
            
            // 設計書: 入力必須、ハイフンありの8文字
            'postal_code' => ['required', 'string', 'size:8', 'regex:/^\d{3}-\d{4}$/'],
            
            // 設計書: 入力必須
            'address'     => ['required', 'string', 'max:255'],
            
            'building'    => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'          => 'プロフィール画像は .jpeg または .png 形式でアップロードしてください',
            'user_name.required'   => 'ユーザー名を入力してください',
            'user_name.max'        => 'ユーザー名は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex'    => '郵便番号はハイフンありの8文字（000-0000）で入力してください',
            'address.required'     => '住所を入力してください',
        ];
    }
}
