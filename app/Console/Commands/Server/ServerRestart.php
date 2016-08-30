<?php 

namespace App\Console\Commands\Server;

use App\Console\Commands\Command;
use App\Surveil\Servers\ServerIgniter;
use Symfony\Component\Process\Process;

class ServerRestart extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:restart 
                            {serverName=default : The id of the server to restart}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Restart a game server";

    protected $igniter;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();
        $this->igniter = new ServerIgniter($this->server);

        if ($this->igniter->restart()) {
            return $this->info('Server "' . $this->server->name . '" restarted');
        }
    }

}
