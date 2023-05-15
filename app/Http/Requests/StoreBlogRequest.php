<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'photo' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
            'reading_time' =>'required|date_format:H : i : s'
        ];
    }
}
