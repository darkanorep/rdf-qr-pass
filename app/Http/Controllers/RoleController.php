<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(Role $role, Response $response)
    {
        $this->baseService = new BaseService($role, $response);
        $this->role = $role;
    }
    public function index(Request $request): \Illuminate\Http\JsonResponse{
        return $this->baseService->index($request, 'Roles');
    }
    public function store(RoleRequest $request):object {
        return $this->baseService->store($request->validated(), 'Role');
    }
    public function show($role): \Illuminate\Http\JsonResponse{
        return $this->baseService->show($role, 'Role');
    }
    public function update(RoleRequest $request, $role): \Illuminate\Http\JsonResponse{
        return $this->baseService->update($request->validated(), $role, 'Role');
    }
    public function changeStatus($role): ?\Illuminate\Http\JsonResponse{
        return $this->baseService->changeStatus($role, 'Role');
    }
}
