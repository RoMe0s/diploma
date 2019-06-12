<?php

namespace App\Http\Requests\Author\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user() && $this->user()->isAuthor()) {
            /** @var Task $task */
            $task = $this->route('task');
            return $task->isEditable();
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['content' => 'required|string|max:1000000'];

        /** @var Task $task */
        $task = $this->route('task');
        if (!$task->order->name) {
            $rules['name'] = 'required|string|max:255';
        }

        return $rules;
    }
}
