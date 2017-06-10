<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\actividad;

class dotask extends Event
{
    use SerializesModels;

    public $actividad;
    public $consulta;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($consulta)
    {
        $this->actividad = new actividad;
        $this->consulta = $consulta;
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
