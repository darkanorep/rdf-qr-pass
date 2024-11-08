<?php

namespace App\Http\Services;

use App\Http\Interfaces\BaseInterface;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\Response;
use App\Models\Attendee;
use App\Models\AttendeeAnswers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class BaseService implements BaseInterface
{
    public function __construct($model, Response $response)
    {
        $this->model = $model;
        $this->response = $response;
    }
    public function index($request, $model): \Illuminate\Http\JsonResponse
    {
        $rows = $request->input('rows', 10);

        return $this->response->fetch($model, $this->model->paginate($rows));
    }

    public function store(array $data, $model): object
    {
        $createdModel = $this->model->create($data);

        switch (true) {
            case $this->model instanceof User:
                return $this->response->registered($createdModel);

            case $this->model instanceof Attendee:
                (new ActionService($createdModel))->isAttending($data);
                return $this->response->registered(new AttendeeResource($createdModel));

            default:
                return $this->response->created($model, $createdModel);
        }
    }
    public function show($id, $model): \Illuminate\Http\JsonResponse
    {
        return $this->response->fetch($model, $this->model->find($id));
    }
    public function update(array $data, $id, $model): \Illuminate\Http\JsonResponse
    {
        $context = $this->model->find($id);

        if (!$context) {
            return $this->response->notFound($model);
        }

        $context->update($data);

        return $this->response->updated($model, $context);
    }
    public function changeStatus($id, $model)
    {
        $context = $this->model->withTrashed()->find($id);

        if ($context) {
            if ($context->trashed()) {
                return $this->response->restored($model, $context->restore());
            } else {
                return $this->response->archived($model, $context->delete());
            }
        } else {
            return $this->response->notFound($model);
        }
    }
}
