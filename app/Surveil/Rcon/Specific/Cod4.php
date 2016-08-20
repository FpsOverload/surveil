<?php

namespace App\Surveil\Rcon\Specific;

use App\Surveil\Rcon\Specific\RconInterface;
use App\Surveil\Rcon\Specific\System\Quake3;

class Cod4 extends Quake3 implements RconInterface {

    function __construct($server)
    {
        parent::__construct($server);
        
        $this->responsePrefix = $this->prefix . "print\n";
    }

    public function getServerStatus()
    {
        dd($this->sendCommand('rcon '.$this->server['server_rcon'].' serverinfo'));
    }

}
