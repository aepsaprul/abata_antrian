<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SitumpurDesainPanggil implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $desain_nomor;
    public $antrian_nomor;
    public $antrian_menunggu;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($desain_nomor, $antrian_nomor, $antrian_menunggu)
    {
        $this->desain_nomor = $desain_nomor;
        $this->antrian_nomor = $antrian_nomor;
        $this->antrian_menunggu = $antrian_menunggu;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['desain-panggil'];
    }

    public function broadcastAs()
    {
        return 'desain-panggil-event';
    }
}
