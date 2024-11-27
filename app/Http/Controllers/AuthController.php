<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\AuthService;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $service;
    public function __construct(AuthService $service, Response $response) {
        $this->service = $service;
    }

    public function login(Request $request) : \Illuminate\Http\JsonResponse {
        return $this->service->login($request);
    }

    public function logout() : \Illuminate\Http\JsonResponse {
        return $this->service->logout();
    }

}
