<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SerialNumberRule;
class EquipmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach ($this->all() as $index => $data) {
            $equipmentTypeId = $data['equipment_type_id'];

            $rules["$index.equipment_type_id"] = "required|exists:equipment_types,id";
            $rules["$index.serial_number"] = ["required", "string", new SerialNumberRule($equipmentTypeId)];
            $rules["$index.desc"] = "nullable|string";
        }

        return $rules;
    }
}
