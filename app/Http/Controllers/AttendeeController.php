<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Http\Services\ActionService;
use App\Http\Services\BaseService;
use App\Http\Traits\Response;
use App\Imports\AttendeesImport;
use App\Imports\EligibleAttendees;
use App\Imports\NonEligibleAttendees;
use App\Models\Attendance;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class AttendeeController extends Controller
{
    private BaseService $baseService;
    private Attendee $attendee;
    private ActionService $actionService;
    private Response $response;

    public function __construct(Attendee $attendee, Response $response) {
        $this->baseService = new BaseService($attendee, $response);
        $this->attendee = $attendee;
        $this->actionService = new ActionService($attendee);
        $this->response = $response;
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
        return $this->baseService->update($request->validated(), $attendee, 'Attendee', AttendeeResource::class);
    }
    public function changeStatus($attendee) : JsonResponse {
        return $this->baseService->changeStatus($attendee, 'Attendee');
    }
    public function preRegisterChecker(Request $request) {
        return $this->actionService->preRegisterChecker($request);
    }
    public function import(Request $request) : JsonResponse {
        $file = $request->file('file');
        Excel::import(new AttendeesImport, $file);

        return $this->response->ok('Attendees imported successfully');
    }
    public function export() : Collection {
        return $this->attendee->attendeesAttendanceReport()->get();
    }
    public function attendance(Request $request) : JsonResponse{
        return $this->actionService->attendance($request);
    }
    public function attendeesList(): Collection
    {
        return $this->attendee->attendeesAttendance()
            ->when(\request()->category == 'minor', function ($query) {
                $query->get();
            }, function ($query) {
                $query->where('employee_id', 'like', '%RDFFLFI%')->get();
            })
            ->get();
    }
    public function attendeesListReport() : LengthAwarePaginator
    {
       return $this->attendee->attendeesAttendanceReport()->paginate(request()->input('per_page', 20));
    }
    public function winner(Request $request) : void {
        $this->actionService->winner($request);
    }
    public function getWinners() : Collection
    {
        return $this->attendee->winners();
    }
    public function resetWinners() : void {
        $this->attendee->wins()->each(fn($attendee) => $attendee->attendance()->restore());
    }

    public function importELigbles(Request $request) {
        $file = $request->file('file');
        Excel::import(new EligibleAttendees, $file);

        return $this->response->ok('Eligible attendees imported successfully');
    }

    public function importNonEligbles(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new NonEligibleAttendees, $file);

        return $this->response->ok('Non-eligible attendees imported successfully');
    }
//    public function attendanceFactory() : void  {
//        Attendance::factory()->present()->count(1000)->create();
//    }
}
