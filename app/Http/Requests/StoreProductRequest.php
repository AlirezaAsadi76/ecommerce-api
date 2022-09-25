<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' =>'required|string',
            'slug' =>'required|string',
            'category_id' =>'required|int',
            'details' =>'required|string',
            'price' =>'required',
            'quantity' =>'required|int',
            'image' => 'required|url',
            'description' =>'required|string',
            'tags' => 'array'

        ];
    }
}
