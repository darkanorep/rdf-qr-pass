<?php

namespace App\Events;

use App\Models\Attendee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendeeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $attendee;

    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('attendance-list')
        ];
    }

    public function broadcastAs(): string
    {
        return 'attendee';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => 'Kung Hei Fat Choi!',
            'id' => $this->attendee->id,
            'employee_id' => $this->attendee->employee_id,
            'department' => $this->attendee->department,
            'full_name' => $this->attendee->first_name . ' ' . $this->attendee->last_name . ' ' . $this->attendee->suffix ?? null,
        ];
    }
}
