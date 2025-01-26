<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PesertaAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $peserta;

    public function __construct($peserta)
    {
        $this->peserta = $peserta;
    }

    public function broadcastOn()
    {
        return new Channel('peserta-lansia');
    }

    public function broadcastWith()
    {
        return [
            'peserta' => $this->peserta,
        ];
    }
}
