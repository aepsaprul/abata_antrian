<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCsSelesai implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $keterangan;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $keterangan)
    {
        $this->cabang_id = $cabang_id;
        $this->keterangan = $keterangan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['cs-selesai'];
    }

    public function broadcastAs()
    {
        return 'cs-selesai-event';
    }
}
