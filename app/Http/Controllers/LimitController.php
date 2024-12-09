<?php

namespace App\Http\Controllers;

use App\Http\Requests\LimitRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Limit;
use Illuminate\Http\Request;

class LimitController extends Controller
{
    public function __construct(Limit $limit, Response $response) {
        $this->baseService = new BaseService($limit, $response);
        $this->limit = $limit;
    }
    public function index(Request $request) : \Illuminate\Http\JsonResponse
    {
        $relation = [
            'group'
        ];
        return $this->baseService->index($request, 'Limits', $relation);
    }
    public function store(LimitRequest $request)
    {
        return $this->baseService->store($request->validated(), 'Limit');
    }
    public function show($limit) {
        return $this->baseService->show($limit, 'Limit');
    }
    public function update(LimitRequest $request, $limit) {
        return $this->baseService->update($request->validated(), $limit, 'Limit');
    }
    public function changeStatus($limit) {
        return $this->baseService->changeStatus($limit, 'Limit');
    }
}
