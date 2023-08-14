<?php

namespace App\Http\Resources;

use http\Env\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($equipment) {
                  return[
                    'id' => $equipment->id,
                    'equipment_type' => new EquipmentTypeResource($equipment->equipmentType),
                    'serial_number' => $equipment->serial_number,
                    'desc' => $equipment->desc,
                    'created_at' => $equipment->created_at,
                    'updated_at' => $equipment->updated_at,
                ];
            }),
        ];
    }
}
