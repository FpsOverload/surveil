<?php

namespace App\Surveil\Rcon;

class ServerRcon {

    public $rcon;

    protected $rconImplementations = [
        'cod4' => App\Surveil\Rcon\Specific\CoD4Rcon::class
    ];

    public function __construct($server)
    {
        $this->setupRcon($server);
    }

    protected function setupRcon($server)
    {
        $rconClass = $this->rconImplementations[$server['game']];
    }

}
