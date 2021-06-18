<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
    public function rules(Request $request)
    {
        //dd($request->category);
        $id = $this->category?$this->category:0;
        return [
            'name' => 'required|max:255|unique:categories,name,'.$id,
            'display_in_menu' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required',
            'name.unique' => 'Name field is unique',
        ];
    }
}
