<?php

namespace App\Events;

use App\Models\PesertaPosyanduLansia;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DaftarHadirRemove implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesertaId;
    public $jadwalId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pesertaId, $jadwalId)
    {
        $this->pesertaId = $pesertaId;
        $this->jadwalId = $jadwalId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // Menggunakan private channel
        return new Channel('daftarhadir-channel.' . $this->jadwalId);
    }

    /**
     * Data yang akan dikirim melalui broadcast
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'peserta_id' => $this->pesertaId,
            'jadwal_id' => $this->jadwalId,
        ];
    }
}
