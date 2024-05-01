<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|min:3|max:128',
            'desc' => 'required|min:56',
            'post_img' => 'image|mimes:jpg,jpeg,png',
        ];
    }

    public function attributes(){
        return [
            'title'=> 'post title',
        ];
    }

    public function messages(){
        return [
        'title.required' => 'The post title field must be required',
        ];
    }
}
