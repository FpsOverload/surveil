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
        $server['config'] = config('surveil.servers.default');
        $server['serverId'] = 'default';

        if ($this->argument('serverId')) {
            $server['config'] = config('surveil.servers.' . $this->argument('serverId'));
            $server['serverId'] = $this->argument('serverId');
        }
        
        if (! $server['config']) {
            throw new InvalidServerException("Server not found");
        }

        return $server;
    }

    protected function addServer($server, $serverId)
    {
        $surveil = json_decode(file_get_contents(base_path('surveil.json')), true);

        $surveil['servers'][$serverId] = $server;

        file_put_contents(base_path('surveil.json'), json_encode($surveil));

        config(['surveil' => $surveil]);

        $this->supervisor->updateSupervisorConfig();
    }

}
