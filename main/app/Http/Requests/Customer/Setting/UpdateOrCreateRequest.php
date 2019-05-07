<?php

namespace App\Http\Requests\Customer\Setting;

use App\Constants\Check\Config;
use App\Services\Checks\Mappings\CheckMappingInterface;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrCreateRequest extends FormRequest
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
        $mapping = $this->resolveCheckMapping();
        return [$this->route('check') => $mapping->getValidationRules()];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        return [$this->route('check') => $this->get('value')];
    }

    /**
     * @return CheckMappingInterface
     */
    private function resolveCheckMapping(): CheckMappingInterface
    {
        return resolve(Config::MAPPINGS_PATH . $this->route('check'));
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            $this->route('check') => __('messages.value')
        ];
    }
}
