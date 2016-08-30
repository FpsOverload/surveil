<?php

namespace App\Exceptions;

class ServerOfflineException extends \Exception {

    function __construct($server)
    {
        $this->server = $server;

        parent::__construct('Server "' . $this->server->name . '" is offline');
    }

}
