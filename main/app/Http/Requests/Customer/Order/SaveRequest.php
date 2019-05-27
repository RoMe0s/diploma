<?php

namespace App\Http\Requests\Customer\Order;

use App\Constants\Plan\Key;
use App\Constants\Plan\Heading;
use App\Constants\Plan\SettingBlock;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Plan\SizeValidator\CheckSubHeadings;
use App\Services\Plan\SizeValidator\CheckTopHeadings;

class SaveRequest extends FormRequest
{
    /**
     * @var array
     */
    private $extraAttributes = [];

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
        $rules = [
            'price' => 'required|numeric|numeric|min:0.01',
            'name' => 'nullable|required_without:description|string|max:255',
            'description' => 'nullable|required_without:name|max:10000',
            'project_id' => 'nullable|exists:projects,id,user_id,' . $this->user()->id,
            'plan.sizes.from' => ['required', 'integer', 'min:0', 'digits_between:0,11'],
            'plan.sizes.to' => ['required', 'integer', 'gte:plan.sizes.from', 'digits_between:0,11'],

            'plan.openingBlock.description' => 'sometimes|required|string|max:10000',
            'plan.openingBlock.sizes.from' => 'sometimes|required|integer|min:0|digits_between:0,11',
            'plan.openingBlock.sizes.to' => 'sometimes|required|integer|digits_between:0,11|gt:plan.openingBlock.sizes.from',
            'plan.openingBlock.keys.*.value' => 'sometimes|required|string|max:255',
            'plan.openingBlock.keys.*.type' => 'sometimes|required|in:' . implode(',', Key::ALL),
            'plan.openingBlock.keys.*.count' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.openingBlock.settings.*.type' => 'sometimes|required|in:' . implode(',', SettingBlock::ALL),
            'plan.openingBlock.settings.*.min' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.openingBlock.settings.*.max' => 'sometimes|required|integer|digits_between:0,11|gte:plan.openingBlock.settings.*.min',

            'plan.closingBlock.description' => 'sometimes|required|string|max:10000',
            'plan.closingBlock.sizes.from' => 'sometimes|required|integer|min:0|digits_between:0,11',
            'plan.closingBlock.sizes.to' => 'sometimes|required|integer|digits_between:0,11|gt:plan.closingBlock.sizes.from',
            'plan.closingBlock.keys.*.value' => 'sometimes|required|string|max:255',
            'plan.closingBlock.keys.*.type' => 'sometimes|required|in:' . implode(',', Key::ALL),
            'plan.closingBlock.keys.*.count' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.closingBlock.settings.*.type' => 'sometimes|required|in:' . implode(',', SettingBlock::ALL),
            'plan.closingBlock.settings.*.min' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.closingBlock.settings.*.max' => 'sometimes|required|integer|digits_between:0,11|gte:plan.closingBlock.settings.*.min',

            'plan.blocks.*.heading' => 'sometimes|in:' . implode(',', Heading::ALL),
            'plan.blocks.*.name' => 'sometimes|required_without:plan.blocks.*.description|string|nullable|max:255',
            'plan.blocks.*.description' => 'sometimes|required_without:plan.blocks.*.name|string|nullable|max:10000',
            'plan.blocks.*.sizes.from' => 'sometimes|required|integer|min:0|digits_between:0,11',
            'plan.blocks.*.sizes.to' => 'sometimes|required|integer|digits_between:0,11|gt:plan.blocks.*.sizes.from',
            'plan.blocks.*.keys.*.value' => 'sometimes|required|string|max:255',
            'plan.blocks.*.keys.*.type' => 'sometimes|required|in:' . implode(',', Key::ALL),
            'plan.blocks.*.keys.*.count' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.blocks.*.settings.*.type' => 'sometimes|required|in:' . implode(',', SettingBlock::ALL),
            'plan.blocks.*.settings.*.min' => 'sometimes|required|integer|min:1|digits_between:0,11',
            'plan.blocks.*.settings.*.max' => 'sometimes|required|integer|gte:plan.blocks.*.settings.*.min|digits_between:0,11',
        ];

        $data = $this->input('plan', []);
        $checkSubBlocks = resolve(CheckSubHeadings::class);
        foreach ($checkSubBlocks->differences($data['blocks'] ?? []) as $field => $rule) {
            $rules[$field] = $rule;
        }

        $checkTopHeadings = resolve(CheckTopHeadings::class);
        foreach ($checkTopHeadings->differences($data) as $field => $rule) {
            $rules[$field][] = $rule;
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return array_merge($this->extraAttributes, [
            'name' => __('fields.name'),
            'price' => __('fields.price'),
            'project_id' => __('fields.project'),
            'description' => __('fields.description'),
            'plan.sizes.from' => __('fields.from'),
            'plan.sizes.to' => __('fields.to'),

            'plan.openingBlock.description' => __('fields.description'),
            'plan.openingBlock.sizes.from' => __('fields.from'),
            'plan.openingBlock.sizes.to' => __('fields.to'),
            'plan.openingBlock.keys.*.value' => __('fields.value'),
            'plan.openingBlock.keys.*.type' => __('fields.type'),
            'plan.openingBlock.keys.*.count' => __('fields.count'),
            'plan.openingBlock.settings.*.type' => __('fields.type'),
            'plan.openingBlock.settings.*.min' => __('fields.min'),
            'plan.openingBlock.settings.*.max' => __('fields.max'),

            'plan.closingBlock.description' => __('fields.description'),
            'plan.closingBlock.sizes.from' => __('fields.from'),
            'plan.closingBlock.sizes.to' => __('fields.to'),
            'plan.closingBlock.keys.*.value' => __('fields.value'),
            'plan.closingBlock.keys.*.type' => __('fields.type'),
            'plan.closingBlock.keys.*.count' => __('fields.count'),
            'plan.closingBlock.settings.*.type' => __('fields.type'),
            'plan.closingBlock.settings.*.min' => __('fields.min'),
            'plan.closingBlock.settings.*.max' => __('fields.max'),

            'plan.blocks.*.heading' => __('fields.heading'),
            'plan.blocks.*.name' => __('fields.name'),
            'plan.blocks.*.description' => __('fields.description'),
            'plan.blocks.*.sizes.from' => __('fields.from'),
            'plan.blocks.*.sizes.to' => __('fields.to'),
            'plan.blocks.*.keys.*.value' => __('fields.value'),
            'plan.blocks.*.keys.*.type' => __('fields.type'),
            'plan.blocks.*.keys.*.count' => __('fields.count'),
            'plan.blocks.*.settings.*.type' => __('fields.type'),
            'plan.blocks.*.settings.*.min' => __('fields.min'),
            'plan.blocks.*.settings.*.max' => __('fields.max')
        ]);
    }
}