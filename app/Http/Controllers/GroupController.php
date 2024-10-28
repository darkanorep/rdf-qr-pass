<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(Group $group, Response $response)
    {
        $this->baseService = new BaseService($group, $response);
        $this->group = $group;
    }
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->baseService->index($request, 'Groups');
    }
    public function store(GroupRequest $request) :object
    {
        return $this->baseService->store($request->validated(), 'Group');
    }
    public function show($group): \Illuminate\Http\JsonResponse
    {
        return $this->baseService->show($group , 'Group');
    }
    public function update(GroupRequest $request, $group): \Illuminate\Http\JsonResponse
    {
        return $this->baseService->update($request->validated(), $group, 'Group');
    }
    public function changeStatus($group): ?\Illuminate\Http\JsonResponse
    {
        return $this->baseService->changeStatus($group, 'Group');
    }

}
