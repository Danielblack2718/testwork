<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($equipmentType) {
                return [
                    'id' => $equipmentType->id,
                    'name' => $equipmentType->name,
                    'mask' => $equipmentType->mask,
                    'created_at' => $equipmentType->created_at,
                    'updated_at' => $equipmentType->updated_at,
                ];
            }),
        ];
    }
}
