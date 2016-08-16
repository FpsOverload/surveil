<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Exceptions\SupervisorNotFoundException;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServerCommand extends Command {

    protected $supervisor;

    function __construct(SupervisorManager $supervisor)
    {
        parent::__construct();
        
        $this->supervisor = $supervisor;
    }

    protected function getServer()
    {

        $config = config('surveil.servers.default');

        if ($this->argument('serverId')) {
            $config = config('surveil.servers.' . $this->argument('serverId'));
        }

        if (!$config) {
            throw new InvalidServerException("Server not found");
        }

        return $config;

    }

    protected function supervisorInstalled()
    {
        return true;
    }

}
