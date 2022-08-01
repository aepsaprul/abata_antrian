<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SitumpurDesainStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $desain_nomor;
    public $status;
    public $nama_desain;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $desain_nomor, $status, $nama_desain)
    {
        $this->cabang_id = $cabang_id;
        $this->desain_nomor = $desain_nomor;
        $this->status = $status;
        $this->nama_desain = $nama_desain;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['desain-status'];
    }

    public function broadcastAs()
    {
        return 'desain-status-event';
    }
}
