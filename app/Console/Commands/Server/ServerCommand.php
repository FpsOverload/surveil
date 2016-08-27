<?php 

namespace App\Console\Commands\Server;

use App\Console\Commands\Command;
use Symfony\Component\Process\Process;

class ServerCommand extends Command {

    protected function serverOnline($serverName)
    {
        $process = new Process('tmux list-sessions 2>&1 | awk "{print $1}" | grep -Ec "' . prefixedServerName($serverName) . ':"');
        $process->run();

        return boolval(rtrim($process->getOutput()));
    }

}
