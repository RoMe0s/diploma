<?php

namespace App\Http\Requests\Customer\Order;

use App\Constants\Status\Order;
use App\Models\User;
use App\Models\Project;
use Illuminate\Validation\Rule;
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
            'orders' => 'required|array',
            'action' => 'required|in:delete',
            'orders.*' => [
                Rule::exists('orders', 'id')->where(function ($builder) {
                    $builder->where('status', Order::DRAFT)->where(function ($builder) {
                        $builder->where(function ($builder) {
                            $builder->where('relation_type', User::class)
                                ->where('relation_id', $this->user()->id);
                        })->orWhere(function ($builder) {
                            $projectSubQuery = Project::query()->where('user_id', $this->user()->id)
                                ->whereRaw('orders.relation_id = projects.id')
                                ->toBase();
                            $builder->where('relation_type', Project::class)
                                ->addWhereExistsQuery($projectSubQuery);
                        });
                    });
                })
            ]
        ];
    }
}
