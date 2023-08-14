<?php

namespace App\Services;

use App\Models\Equipment;
use App\Http\Requests\EquipmentUpdateRequest;
use App\Http\Resources\EquipmentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EquipmentCollection;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Resources\EquipmentTypeResource;
use Illuminate\Http\Request;
use App\Rules\SerialNumberRule;

class EquipmentService
{
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->has('q') || $request->has('query')) {
            $searchTerm = $request->input('q') ?: $request->input('query');
            $query->where('serial_number', 'like', '%' . $searchTerm . '%')
                ->orWhere('desc', 'like', '%' . $searchTerm . '%');
        }

        /** @var TYPE_NAME $equipment */
        $equipment = $query->paginate($request->input('perPage'));

        if ($equipment->isEmpty()) {
            return response()->json(['message' => 'No equipment found'], 404);
        }

        return new EquipmentCollection($equipment);
    }

    public function showEquipment($id)
    {
        $equipment = Equipment::find($id);
        if (!$equipment) {
            return [
                "error" => 'Equipment not found',
                "code" => '404'
            ];
        }
        return new EquipmentResource($equipment);
    }

    public function createEquipment(EquipmentStoreRequest $request)
    {
        $response = [
            'errors' => [],
            'success' => []
        ];

        try {
            DB::beginTransaction();

            foreach ($request->validated() as $index => $data) {
                if (Equipment::where('serial_number', $data['serial_number'])->exists()) {
                    throw new \Exception('This serial number already exists',422);
                    $response['errors'] = ['Serial number already exists'];
                } else {
                    $equipment = Equipment::create($data);

                    if (!$equipment) {
                        $response['errors'][$index] = ['Equipment not found'];
                    } else {
                        $equipmentResource = new EquipmentResource($equipment);
                        $response['success'][$index] = $equipmentResource;
                    }
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $errorText = $exception->getMessage();
            $errors[] = [
                "error" => $errorText,
                "code" => $exception->getCode()
            ];

            $response['errors'][] = $errors;
        }

        return $response;
    }




    public function updateEquipment($id, EquipmentUpdateRequest $request)
    {
        $errors = [];
        $successData = [];

        try {
            $equipment = Equipment::findOrFail($id);

            DB::beginTransaction();
            if (Equipment::where('serial_number', $request['0.serial_number'])->exists()) {
                throw new \Exception('This serial number already exists',421);
                $response['errors'] = ['Serial number already exists'];
            }
            $dataTemp = [
                'serial_number'=>$request['0.serial_number'],
                'equipment_type_id'=>$request['0.equipment_type_id'],
                'desc'=>$request['0.desc']
            ];
            $equipment->update($dataTemp);

            DB::commit();

            $successData[] = new EquipmentResource($equipment);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();

            $errorCode = $exception->getCode();
            $errorText = $exception->getMessage();
            $errors[] = [
                "error" => $errorText,
                "code" => $errorCode
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            $errorText = $exception->getMessage();
            $errors[] = [
                "error" => $errorText,
                "code" => $exception->getCode()
            ];
        }

        $response = [
            "errors" => $errors,
            "success" => $successData
        ];

        return $response;
    }
    public function destroyEquipment($id)
    {
        $equipment = Equipment::findOrFail($id);

        if (!$equipment) {
            return response()->json(['error' => 'Equipment not found'], 404);
        }

        $equipment->delete();
        return response()->json(['success' => [
            'id' => $id,
            'message' => 'Equipment deleted successfully']
        ], 200);
    }
}
