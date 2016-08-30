<?php 

namespace App\Console\Commands\Server;

use App\Console\Commands\Command;
use App\Exceptions\CommandFailedException;
use App\Surveil\Servers\ServerIgniter;
use Symfony\Component\Process\Process;

class ServerStop extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:stop 
                            {serverName=default : The id of the server to stop}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Stop a game server";

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

        if ($this->igniter->stop()) {
            return $this->info('Server "' . $this->server->name . '" stopped');
        }
    }

}
