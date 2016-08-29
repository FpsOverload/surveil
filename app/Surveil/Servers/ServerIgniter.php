<?php

namespace App\Surveil\Servers;

use App\Configuration;
use App\Server;

class ServerIgniter {

    /* 
     * Instance of App\Server
     */
    protected $server;

    function __construct(Server $server, Configuration $config)
    {
        $this->server = $server;
    }

    /*
     * Start the game server.
     */
    public function start()
    {
        // Check server offline
        // Find active configuration
        // Build command
        // Start server
        // Check server online
    }

    /*
     * Stop the game server.
     */
    public function stop()
    {
        // Check server online
        // Stop server
        // Check server offline
    }

    public function status()
    {

    }

    /*
     * Restart the game server.
     */
    public function restart()
    {
        $this->stop();
        $this->start();
    }

}
