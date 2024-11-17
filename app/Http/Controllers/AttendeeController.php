<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Http\Services\ActionService;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Attendee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function __construct(Attendee $attendee, Response $response) {
        $this->baseService = new BaseService($attendee, $response);
        $this->attendee = $attendee;
        $this->actionService = new ActionService($attendee);
    }
    public function index(Request $request) : JsonResponse
    {
        $relation = [
            'group' => fn($query) => $query->select('id', 'name'),
            'building' => fn($query) => $query->select('id', 'name')
        ];
        return $this->baseService->index($request, 'Attendees', $relation);
    }
    public function store(AttendeeRequest $request) : JsonResponse
    {
        return $this->baseService->store($request->validated(), 'Attendee');
    }
    public function show($attendee) : JsonResponse {
        return $this->baseService->show($attendee, 'Attendee', AttendeeResource::class);
    }
    public function update(AttendeeRequest $request, $attendee) : JsonResponse {
        return $this->baseService->update($request->validated(), $attendee, 'Attendee');
    }
    public function changeStatus($attendee) : JsonResponse {
        return $this->baseService->changeStatus($attendee, 'Attendee');
    }
    public function readQR(Request $request) : JsonResponse {
        return $this->actionService->readQR($request);
    }

    public function preRegisterChecker(Request $request) {
        return $this->actionService->preRegisterChecker($request);
    }

    public function findQR(Request $request) {
        return $this->actionService->findQR($request);
    }
}
