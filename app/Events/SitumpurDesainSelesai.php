<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SitumpurDesainSelesai implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $desain_nomor;
    public $keterangan;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($desain_nomor, $keterangan)
    {
        $this->desain_nomor = $desain_nomor;
        $this->keterangan = $keterangan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['desain-selesai'];
    }

    public function broadcastAs()
    {
        return 'desain-selesai-event';
    }
}
