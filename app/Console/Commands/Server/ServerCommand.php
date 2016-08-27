<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Exceptions\ProcessFailedException;
use App\Server;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServerCommand extends Command {

    protected $server;

    function __construct(Server $server)
    {
        parent::__construct();

        $this->server = $server;
    }

    protected function serverFromArgument()
    {
        if ($this->argument('serverName')) {
            $this->server = Server::where('name', $this->argument('serverName'))->first();
        }

        if (! $this->server) {
            throw new InvalidServerException(trans('servers.not_found', ['server' => $this->argument('serverName')]));
        }

        return;
    }

    protected function serverOnline($serverName)
    {
        $process = new Process('tmux list-sessions 2>&1 | awk "{print $1}" | grep -Ec "' . $this->prefixedServerName($serverName) . ':"');
        $process->run();

        return boolval(rtrim($process->getOutput()));
    }

    protected function prefixedServerName($serverName)
    {
        return config('surveil.prefix') . $serverName;
    }

    protected function logPath($logName, $logType = null)
    {
        if ($logType) {
            return config('surveil.logPath') . $logName . '-' . $logType . '.log';
        }

        return config('surveil.logPath') . $logName . '.log';
    }

}
