<?php

namespace App\Http\Requests\Customer\Project;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => 'required|in:delete',
            'projects' => 'required|array',
            'projects.*' => 'exists:projects,id,user_id,' . $this->user()->id
        ];
    }
}
