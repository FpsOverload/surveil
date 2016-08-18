<?php 

namespace App\Console\Commands\Rcon;

use Illuminate\Console\Command;

class ServerCommand extends Command {

    protected $server, $serverId;

    protected $rconClient;

    function __construct()
    {
        parent::__construct();
    }

    public function connectToServer()
    {
        if ($this->argument('serverId')) {
            $this->server = config('surveil.servers.' . $this->argument('serverId'));
            $this->serverId = $this->argument('serverId');
        }

        if (! $this->server) {
            throw new InvalidServerException("Server not found");
        }

        return;
    }

}
