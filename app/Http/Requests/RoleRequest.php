<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $editRule = $id == null ? '' : ',name,' . $id;

        return [
            'name' => 'required|unique:roles' . $editRule,
            'permission_id' => 'required|array',
        ];
    }
}
