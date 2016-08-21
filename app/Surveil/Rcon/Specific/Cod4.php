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

    public function serverStatus()
    {
        $regex = '^\s*(?P<slot>[0-9]+)\s+' .
                '(?P<score>[0-9-]+)\s+' .
                '(?P<ping>[0-9]+)\s+' .
                '(?P<guid>[0-9a-zA-Z]+)\s+' .
                '(?P<name>.*?)\s+' .
                '(?P<lastmsg>[0-9]+?)\s*' .
                '(?P<address>(?:(?:25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\.){3}' .
                '(?:25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])):?' .
                '(?P<port>-?[0-9]{1,5})\s*' .
                '(?P<qport>-?[0-9]{1,5})\s+' .
                '(?P<rate>[0-9]+)';

        $response = $this->sendCommand('rcon '.$this->server['server_rcon'].' status');

        $matches = [];
        
        preg_match('/' . $regex . '/m', $response, $matches);
        
        return $matches;
    }

    public function serverInfo()
    {
        $response['server_name'] = $this->getCvar('sv_hostname');
        $response['map_name'] = $this->getCvar('mapname');
        $response['game_type'] = $this->getCvar('g_gametype');

        dd($response['game_type']);

        return $response;
    }

    public function serverOverview()
    {
        $response['players'] = $this->serverStatus();
        $response['info'] = $this->serverInfo();

        return $response;
    }

    public function getCvar($cvar)
    {
        return $this->sendCommand('rcon ' . $this->server['server_rcon'] . ' ' . $cvar);
    }
    
}
