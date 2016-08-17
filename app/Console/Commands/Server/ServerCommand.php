<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\InvalidServerException;
use App\Exceptions\SupervisorNotFoundException;
use App\Surveil\Supervisor\SupervisorManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ServerCommand extends Command {

    protected $supervisor, $server, $serverId;

    function __construct(SupervisorManager $supervisor)
    {
        parent::__construct();

        $this->supervisor = $supervisor;
    }

    protected function getServer()
    {
        $this->server = config('surveil.servers.default');
        $this->serverId = 'default';

        if ($this->argument('serverId')) {
            $this->server = config('surveil.servers.' . $this->argument('serverId'));
            $this->serverId = $this->argument('serverId');
        }

        if (! $this->server) {
            throw new InvalidServerException("Server not found");
        }

        return;
    }

    protected function addServer($server, $serverId)
    {
        $surveil = json_decode(file_get_contents(base_path('surveil.json')), true);

        $surveil['servers'][$serverId] = $server;

        file_put_contents(base_path('surveil.json'), json_encode($surveil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        config(['surveil' => $surveil]);

        $this->supervisor->updateSupervisorConfig();
    }

    protected function deleteServer($serverId)
    {
        $surveil = json_decode(file_get_contents(base_path('surveil.json')), true);

        unset($surveil['servers'][$serverId]);

        file_put_contents(base_path('surveil.json'), json_encode($surveil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        config(['surveil' => $surveil]);

        $this->supervisor->updateSupervisorConfig();
    }

}
