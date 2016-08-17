<?php 

namespace App\Console\Commands\Server;

use Symfony\Component\Process\Process;

class ServerStop extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:stop 
                            {serverId? : The id of the server to stop}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Stop a game server";

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
        
        $command = 'supervisorctl stop ' . $this->supervisor->supervisorProgramForServer($this->serverId);
        (new Process($command))->setTimeout(null)->run(function($type, $line)
        {
            $this->info($line);
        });
    }

}
