<?php

namespace App\Http\Requests\Author\Task;

use App\Models\Task\Task;
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
        return ['content' => 'required|string|max:1000000'];
    }
}
