<?php 

namespace App\Console\Commands\Server;

use Symfony\Component\Process\Process;

class ServerStart extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:start 
                            {serverId? : The id of the server to start}
                            {--s|unsupervised : Start the server manually, not through supervisor}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start a game server";

    protected $server = [];
    protected $serverId = "";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            $server = $this->getServer();

            $this->serverId = $server['serverId'];
            $this->server = $server['config'];
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }
        
        if ($this->option('unsupervised')) {
            return $this->startUnsupervisedServer();
        }

        return $this->startSupervisedServer();
    }

    protected function startSupervisedServer()
    {
        $command = 'supervisorctl start ' . $this->supervisor->supervisorProgramForServer($this->serverId);
        (new Process($command))->setTimeout(null)->run(function($type, $line)
        {
            $this->info($line);
        });
    }

    protected function startUnsupervisedServer()
    {
        $command = 'cd ' . $this->server['path'] . ' && ./' . $this->server['binary'] . ' ' . $this->server['startup_params'];
        (new Process($command))->setTimeout(null)->run(function($type, $line)
        {
            $this->info($line);
        });
    }

}
