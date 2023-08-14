<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\Equipment;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\EquipmentService;

class EquipmentController extends Controller
{
    /**
     * @var EquipmentService
     */
    protected $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        /** @var TYPE_NAME $this */
        $this->equipmentService = $equipmentService;
    }

    public function index(Request $request)
    {
        /** @var TYPE_NAME $this */
        return $this->equipmentService->index($request);
    }

    public function show($id)
    {
        /** @var TYPE_NAME $response */
        $response = $this->equipmentService->showEquipment($id);

        if (isset($response['error'])) {
            return response()->json($response, 404);
        }

        /** @var TYPE_NAME $response */
        return $response;
    }

    public function store(EquipmentStoreRequest $request)
    {
        /** @var TYPE_NAME $response */
        $response = $this->equipmentService->createEquipment($request);

        if (count($response['errors']) !== 0) {
            return response()->json($response, 422);
        }

        return $response;
    }



    public function update(EquipmentUpdateRequest $request, $id)
    {
        /** @var TYPE_NAME $response */
        $response = $this->equipmentService->updateEquipment($id, $request);

        if (count($response['errors']) !== 0) {
            return response()->json($response, 421);
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        /** @var TYPE_NAME $this */
        return $this->equipmentService->destroyEquipment($id);
    }

}
