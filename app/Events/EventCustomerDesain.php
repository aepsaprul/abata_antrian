<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventCustomerDesain implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cabang_id;
    public $nomor_antrian;
    public $nama;
    public $telepon;
    public $customer_filter_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cabang_id, $nomor_antrian, $nama, $telepon, $customer_filter_id)
    {
        $this->cabang_id = $cabang_id;
        $this->nomor_antrian = $nomor_antrian;
        $this->nama = $nama;
        $this->telepon = $telepon;
        $this->customer_filter_id = $customer_filter_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['customer-desain'];
    }

    public function broadcastAs()
    {
        return 'customer-desain-event';
    }
}
