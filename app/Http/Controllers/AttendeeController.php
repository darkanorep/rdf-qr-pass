<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendeeRequest;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function __construct(Attendee $attendee, Response $response) {
        $this->baseService = new BaseService($attendee, $response);
        $this->attendee = $attendee;
    }

    public function index(Request $request)
    {
        return $this->baseService->index($request, 'Attendees');
    }

    public function store(AttendeeRequest $request)
    {
        return $this->baseService->store($request->validated(), 'Attendee');
    }

    public function show($attendee) {
        return $this->baseService->show($attendee, 'Attendee');
    }

    public function update(AttendeeRequest $request, $attendee) {
        return $this->baseService->update($request->validated(), $attendee, 'Attendee');
    }

    public function changeStatus($attendee) {
        return $this->baseService->changeStatus($attendee, 'Attendee');
    }
}
