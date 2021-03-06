<?php

namespace App\Exceptions;

class CommandFailedException extends \Exception {

    function __construct($server)
    {
        $this->server = $server;

        parent::__construct('Server "' . $this->server->name . '" failed to start');
    }

}
