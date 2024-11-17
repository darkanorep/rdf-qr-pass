<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

class Response
{

    public function ok($message = 'Success', $data = []) : JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function created($model, $data): JsonResponse
    {
        return response()->json([
            'message' => $model .' successfully created',
            'data' => $data
        ], 201);
    }

    public function updated($model, $data) : JsonResponse
    {
        return response()->json([
            'message' => $model .' successfully updated',
            'data' => $data
        ], 200);
    }

    public function error($message = 'Error', $code = 400) : JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    public function fetch($model, $data) : JsonResponse
    {
        return response()->json([
            'message' => $model .' successfully fetched',
            'data' => $data
        ], 200);
    }

    public function archived($model, $data) : JsonResponse
    {
        return response()->json([
            'message' => $model .' successfully archived',
            'data' => $data
        ], 200);
    }

    public function restored($model, $data) : JsonResponse
    {
        return response()->json([
            'message' => $model .' successfully restored',
            'data' => $data
        ], 200);
    }

    public function registered($data) : JsonResponse
    {
        return response()->json([
            'message' => 'Successfully registered.',
            'data' => $data
        ], 200);
    }

    public function notFound($model) : JsonResponse
    {
        return response()->json([
            'message' => $model .' not found'
        ], 404);
    }
}
