<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Server;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;

class ServerCommand extends Command {

    protected $supervisor, $server, $serverName;

    function __construct(SupervisorManager $supervisor, Server $server)
    {
        parent::__construct();

        $this->supervisor = $supervisor;
        $this->server = $server;
    }

    protected function getServer()
    {
        if ($this->argument('serverName')) {
            $this->server = Server::where('name', $this->argument('serverName'))->firstOrFail();
            $this->serverName = $this->argument('serverName');
        }

        if (! $this->server) {
            throw new InvalidServerException("Server not found");
        }

        return;
    }

    protected function createServer($server)
    {
        Server::create($server);

        $this->supervisor->updateSupervisorConfig();
    }

    protected function deleteServer($serverName)
    {
        Server::where('name', $serverName)->delete();

        $this->supervisor->updateSupervisorConfig();
    }

}
