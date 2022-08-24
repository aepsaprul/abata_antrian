<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCsToDesain implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $antrian_nomor;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $antrian_nomor)
    {
        $this->cabang_id = $cabang_id;
        $this->antrian_nomor = $antrian_nomor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['cs-to-desain'];
    }

    public function broadcastAs()
    {
        return 'cs-to-desain-event';
    }
}
