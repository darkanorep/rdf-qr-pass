<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(User $user, Response $response) {
        $this->baseService = new BaseService($user, $response);
        $this->user = $user;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse{
        $relation = [
            'role' => fn($query) => $query->select('id', 'name'),
            'permissions',
        ];
        return $this->baseService->index($request, 'Users', $relation);
    }

    public function store(UserRequest $request):object {
        return $this->baseService->store($request->validated(), 'User');
    }

    public function show($user): \Illuminate\Http\JsonResponse{
        return $this->baseService->show($user, 'User', UserResource::class);
    }

    public function update(UserRequest $request, $user): \Illuminate\Http\JsonResponse{
        return $this->baseService->update($request->validated(), $user, 'User', UserResource::class);
    }

    public function changeStatus($user): ?\Illuminate\Http\JsonResponse{
        return $this->baseService->changeStatus($user, 'User');
    }
}
