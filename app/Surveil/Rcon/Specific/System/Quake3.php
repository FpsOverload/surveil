<?php

namespace App\Surveil\Rcon\Specific\System;

class Quake3 extends BaseSystem {

    protected $socket, $prefix;

    function __construct($server)
    {
        parent::__construct($server);
        
        $this->prefix = str_repeat(chr(255), 4);
        $this->responsePrefix = $this->prefix;

        $this->socket = fsockopen("udp://" . $server->ip, $server->port, $errno, $errstr, 30);

        if (!$this->socket) {
            throw new \Exception("Could not connect to server.");
        }
    }

    protected function sendCommand($command)
    {
        fwrite($this->socket, $this->prefix . $command . "\n");

        return $this->response();
    }

    protected function response($timeout = 2) {
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

    protected function readSocket() {
        return fread($this->socket, 9999);
    }

}
