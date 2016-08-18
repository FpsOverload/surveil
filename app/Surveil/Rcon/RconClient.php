<?php

namespace App\Surveil\Rcon;

use App\Exceptions\RconImplementationNotFoundException;

class RconClient {

    public $connection;

    protected $rconImplementations = [
        'cod4' => App\Surveil\Rcon\Specific\CoD4Rcon::class
    ];

    public function setupRcon($server)
    {
        if (!isset($server['server_game'])) {
            throw new RconImplementationNotFoundException("Server game not set");
        }
        $rconClass = $this->rconImplementations[$server['server_game']];

        dd($rconClass);
    }

}
