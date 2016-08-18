<?php 

namespace App\Console\Commands\Rcon;

use App\Surveil\Rcon\RconClient;
use Illuminate\Console\Command;

class RconCommand extends Command {

    protected $server, $serverId, $rconClient;

    function __construct(RconClient $rconClient)
    {
        parent::__construct();

        $this->rconClient = $rconClient;
    }

    public function connectToServer()
    {
        if ($this->argument('serverId')) {
            $this->server = config('surveil.servers.' . $this->argument('serverId'));
            $this->serverId = $this->argument('serverId');

            $this->rconClient->setupRcon($this->server);
        }

        if (! $this->server) {
            throw new InvalidServerException("Server not found");
        }

        return;
    }

}
