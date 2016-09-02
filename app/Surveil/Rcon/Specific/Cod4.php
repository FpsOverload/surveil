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

        $response = collect(explode("\n", $response))->map(function ($line, $key) use ($regex) {
            preg_match('/' . $regex . '/', $line, $matches);

            return collect($matches)->reject(function ($value, $key) {
                return is_int($key);
            });
        })->reject(function ($value) {
            return $value->isEmpty();
        });

        return $response;
    }

    public function serverInfo()
    {
        $response['server_name'] = $this->getCvar('sv_hostname');
        $response['map_name'] = $this->getCvar('mapname');
        $response['game_type'] = $this->getCvar('g_gametype');

        return $response;
    }

    public function serverOverview()
    {
        $response['players'] = $this->serverStatus();
        $response['info'] = $this->serverInfo();

        return $response;
    }

    public function serverMap()
    {
        return $this->getCvar('map_name');
    }

    public function getCvar($cvar)
    {
        $regex = '^"(?P<cvar>[a-z0-9_.]+)"\s+is:\s*"(?P<value>.*?)(\^7)?"\s+default:\s*"(?P<default>.*?)(\^7)?"$';

        $response = $this->sendCommand('rcon ' . $this->server['server_rcon'] . ' ' . $cvar);

        preg_match('/' . $regex . '/', $response, $matches);

        if (isset($matches['value'])) {
            return $matches['value'];
        }
    }

}
