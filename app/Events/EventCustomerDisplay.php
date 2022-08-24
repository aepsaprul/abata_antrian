<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCustomerDisplay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $total_antrian;
    public $customer_filter_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $total_antrian, $customer_filter_id)
    {
        $this->cabang_id = $cabang_id;
        $this->total_antrian = $total_antrian;
        $this->customer_filter_id = $customer_filter_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['customer-display'];
    }

    public function broadcastAs()
    {
        return 'customer-display-event';
    }
}
