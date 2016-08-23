<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Server;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;

class ServerCommand extends Command {

    protected $supervisor, $server, $serverId;

    function __construct(SupervisorManager $supervisor)
    {
        parent::__construct();

        $this->supervisor = $supervisor;
    }

    protected function getServer()
    {
        if ($this->argument('serverId')) {
            $this->server = Server::where('name', $this->argument('serverId'))->firstOrFail();
            $this->serverId = $this->argument('serverId');
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

    protected function deleteServer($serverId)
    {
        Server::where('name', $serverId)->delete();

        $this->supervisor->updateSupervisorConfig();
    }

}
