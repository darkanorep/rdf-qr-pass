<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Color;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct(Color $color, Response $response) {
        $this->baseService = new BaseService($color, $response);
    }

    public function index(Request $request) : JsonResponse {
        return $this->baseService->index($request, 'Colors');
    }

    public function store(ColorRequest $request) : JsonResponse {
        return $this->baseService->store($request->validated(), 'Color');
    }

    public function show($color) : JsonResponse {
        return $this->baseService->show($color, 'Color');
    }

    public function update(ColorRequest $request, $color) : JsonResponse {
        return $this->baseService->update($request->validated(), $color, 'Color');
    }

    public function changeStatus($color) : JsonResponse {
        return $this->baseService->changeStatus($color, 'Color');
    }
}
