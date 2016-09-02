<?php

namespace App\Surveil\Rcon;

use App\Exceptions\RconImplementationNotFoundException;
use App\Surveil\Rcon\Specific\Cod4;

class RconClient {

    public $connection;

    protected $rconImplementations = [
        'cod4' => Cod4::class
    ];

    function __construct($server = null)
    {
        if ($server) {
            $this->setupRcon($server);
        }
    }

    public function setupRcon($server)
    {
        if (!isset($server->game)) {
            throw new RconImplementationNotFoundException("Server game not set");
        }

        try {
            $rconClass = $this->rconImplementations[$server->game];
        } catch (\Exception $e) {
            throw new RconImplementationNotFoundException("No implementation for game: " . $server->game);
        }

        $this->connection = new $rconClass($server);
    }

}
