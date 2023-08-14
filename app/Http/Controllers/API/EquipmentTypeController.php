<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index(Request $request)
    {
        // Пагинация и фильтрация поиска
        $query = EquipmentType::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $equipmentTypes = $query->paginate(10);

        return EquipmentTypeResource::collection($equipmentTypes);
    }
}
