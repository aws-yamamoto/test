<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoItemRequest extends FormRequest
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
            'info_item_name' => 'required|string|max:255'
        ];
    }
}
