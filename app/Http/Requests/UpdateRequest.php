<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'message' => 'required|max:1000',
        ];
    }
}
