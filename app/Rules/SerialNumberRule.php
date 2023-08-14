<?php
// app/Rules/SerialNumberRule.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\EquipmentType;

class SerialNumberRule implements Rule
{
    protected $equipmentTypeId;
    protected $equipmentType;
    public function __construct($equipmentTypeId)
    {
        $this->equipmentTypeId = $equipmentTypeId;
    }

    public function passes($attribute, $value)
    {
        $this->equipmentType = EquipmentType::find($this->equipmentTypeId);

        if (!$this->equipmentType) {
            return false;
        }

        $mask = $this->equipmentType->mask;

        return $this->validateSerialNumber($value, $mask);
    }

    public function message()
    {
        return 'The :attribute has invalid format for this equipment type.';
    }

    protected function validateSerialNumber($serialNumber, $mask)
    {
        $allowedChars = 'NAaXZ';
        $result = true;
        if(strlen($serialNumber)!=strlen($mask)){
            return false;
        }
        for ($i = 0; $i < strlen($serialNumber); $i++) {
            $maskChar = $mask[$i];
            $serialChar = $serialNumber[$i];

            if (strpos($allowedChars, $maskChar) !== false) {
                if ($maskChar === 'N' && !is_numeric($serialChar)) {
                    $result = false;
                    break;
                } elseif ($maskChar === 'A' && !ctype_upper($serialChar)) {
                    $result = false;
                    break;
                } elseif ($maskChar === 'a' && !ctype_lower($serialChar)) {
                    $result = false;
                    break;
                } elseif ($maskChar === 'X' && !ctype_alnum($serialChar)) {
                    $result = false;
                    break;
                } elseif ($maskChar === 'Z' && !in_array($serialChar, ['-', '_', '@'])) {
                    $result = false;
                    break;
                }
            } elseif ($maskChar !== $serialChar) {
                $result = false;
                break;
            }
        }

        return $result;
    }
}
