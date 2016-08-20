<?php

namespace App\Surveil\Rcon\Specific\System;

class BaseSystem {

    protected $server;

    function __construct($server)
    {
        $this->server = $server;
    }

}
