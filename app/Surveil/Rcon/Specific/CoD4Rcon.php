<?php

namespace App\Surveil\Rcon\Specific;

class CoD4Rcon implements RconInterface {

    protected $socket, $prefix, $server;

    function __construct($server)
    {
        $this->server = $server;
        $this->prefix = str_repeat(chr(255), 4);
        $this->responsePrefix = $this->prefix . "print\n";
        $this->socket = fsockopen("udp://" . $server['server_ip'], $server['server_port'], $errno, $errstr, 30);

        if (!$this->socket) {
            throw new \Exception("Could not connect to server.");
        }
    }

    public function getServerStatus()
    {
        $this->sendCommand('rcon '.$this->server['server_rcon'].' serverinfo');
    }

    private function sendCommand($command)
    {
        fwrite($this->socket, $this->prefix . $command . "\n");

        dd($this->response());
    }

    public function response($timeout = 2) {
        $response = '';
        $timeout = time() + $timeout;

        while (!strlen($response) && time() < $timeout) {
            $response = $this->readSocket();
        }

        if (substr($response, 0, strlen($this->responsePrefix)) != $this->responsePrefix) {
            return $response;
        }

        return substr($response, strlen($this->responsePrefix));
    }

     private function readSocket() {
        return fread($this->socket, 9999);
    }

}
