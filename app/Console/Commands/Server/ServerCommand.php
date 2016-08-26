<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Server;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;

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
            throw new InvalidServerException('Server "' . $this->argument('serverName') . '" not found.');
        }

        return;
    }

    protected function serverStatus($serverName)
    {

    }

    protected function prefixedServerName($serverName)
    {
        return config('surveil.prefix') . $serverName;
    }

    protected function logPath($logName, $logType = null)
    {
        if ($logType) {
            return config('surveil.logPath') . $logName . ' - ' . $logType . '.log';
        }

        return config('surveil.logPath') . $logName . '.log';
    }

}
