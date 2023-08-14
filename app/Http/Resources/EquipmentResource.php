<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
/**
* Transform the resource into an array.
*
* @param \Illuminate\Http\Request $request
* @return array
*/
public function toArray($request)
{
return [
'id' => $this->id,
'equipment_type' => new EquipmentTypeResource($this->equipmentType),
'serial_number' => $this->serial_number,
'desc' => $this->desc,
'created_at' => $this->created_at,
'updated_at' => $this->updated_at,
];
}
}
