<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(User $user, Response $response) {
        $this->baseService = new BaseService($user, $response);
        $this->user = $user;
    }

    public function signup(UserRequest $request) {
        return $this->baseService->store($request->validated(), 'User');
    }

}
