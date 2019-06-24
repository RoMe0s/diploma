<?php

namespace App\Http\Requests\Task\Chat;

use App\Models\Task\Task;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required|string|max:1000'
        ];
    }
}
