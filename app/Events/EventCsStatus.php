<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCsStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $status;
    public $nama_cs;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $status, $nama_cs)
    {
        $this->cabang_id = $cabang_id;
        $this->status = $status;
        $this->nama_cs = $nama_cs;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['cs-status'];
    }

    public function broadcastAs()
    {
        return 'cs-status-event';
    }
}
