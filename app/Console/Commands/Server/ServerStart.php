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
                            {serverName=default : The id of the server to start}
                            {--s|unsupervised : Start the server manually, not through supervisor}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start a game server";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->getServer();
        
        if ($this->option('unsupervised')) {
            return $this->startUnsupervisedServer();
        }

        return $this->startSupervisedServer();
    }

    protected function startSupervisedServer()
    {
        $command = 'supervisorctl start ' . $this->supervisor->supervisorProgramForServer($this->server->name);
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
