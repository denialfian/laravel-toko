<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
        $id = request()->route('id');
        $editRuleName = $id == null ? '' : ',name,' . $id;
        $editRuleLevel = $id == null ? '' : ',level,' . $id;

        return [
            'name' => 'required|unique:positions' . $editRuleName,
            'level' => 'required|numeric|unique:positions' . $editRuleLevel,
        ];
    }
}
