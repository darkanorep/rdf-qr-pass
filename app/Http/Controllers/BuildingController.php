<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function __construct(Building $building, Response $response)
    {
        $this->baseService = new BaseService($building, $response);
        $this->building = $building;
    }

    public function index(Request $request): JsonResponse
    {
        $relations = [
            'color' => fn($query) => $query->select('id', 'name', 'hex')
        ];

        return $this->baseService->index($request, 'Building', $relations);
    }

    public function store(BuildingRequest $request) : JsonResponse {
        return $this->baseService->store($request->validated(), 'Building');
    }

    public function show($building): JsonResponse {
        return $this->baseService->show($building, 'Building', BuildingResource::class);
    }

    public function update($building, BuildingRequest $request) : JsonResponse {
        return $this->baseService->update($request->validated(), $building, 'Building');
    }

    public function changeStatus($building) : JsonResponse{
        return $this->baseService->changeStatus($building, 'Building');
    }
}
