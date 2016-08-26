<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\CommandFailedException;
use Symfony\Component\Process\Process;

class ServerStop extends ServerCommand {
    
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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();

        $process = new Process('tmux kill-session -t "' . $this->prefixedServerName($this->server->name) . '"');
        $process->setTimeout(10);
        $process->run();


        if (!$process->isSuccessful()) {
            if ($this->serverOnline($this->server->name)) {
                throw new CommandFailedException('Server "' . $this->server->name . '" failed to stop');
            }

            return $this->info('Server "' . $this->server->name . '" already stopped');
        }

        if ($this->serverOnline($this->server->name)) {
            throw new CommandFailedException('Server "' . $this->server->name . '" failed to stop');
        }

        return $this->info('Server "' . $this->server->name . '" stopped');
    }

}
