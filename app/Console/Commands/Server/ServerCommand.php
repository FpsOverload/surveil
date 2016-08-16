<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Exceptions\SupervisorNotFoundException;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServerCommand extends Command {

    protected function getServer()
    {

        $config = config('servers.servers.default');

        if ($this->argument('serverId')) {
            $config = config('servers.servers.' . $this->argument('serverId'));
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
