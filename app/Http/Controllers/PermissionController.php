<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(Permission $permission, Response $response)
    {
        $this->baseService = new BaseService($permission, $response);
        $this->permission = $permission;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $relation = [
            'users'
        ];
        return $this->baseService->index($request, 'Permissions', $relation);
    }

    public function store(PermissionRequest $request)
    {
        return $this->baseService->store($request->validated(), 'Permissions');
    }

    public function show($permission)
    {
        return $this->baseService->show($permission, 'Permissions');
    }

    public function update(PermissionRequest $request, $permission)
    {
        return $this->baseService->update($request->validated(), $permission, 'Permissions');
    }

    public function changeStatus($permission)
    {
        return $this->baseService->changeStatus($permission, 'Permissions');
    }
}
