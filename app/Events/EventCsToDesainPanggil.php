<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCsToDesainPanggil implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $desain_nomor;
    public $antrian_nomor;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $desain_nomor, $antrian_nomor)
    {
        $this->cabang_id = $cabang_id;
        $this->desain_nomor = $desain_nomor;
        $this->antrian_nomor = $antrian_nomor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['cs-to-desain-panggil'];
    }

    public function broadcastAs()
    {
        return 'cs-to-desain-panggil-event';
    }
}
