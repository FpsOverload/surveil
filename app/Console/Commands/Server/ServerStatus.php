<?php 

namespace App\Console\Commands\Server;

use Symfony\Component\Process\Process;

class ServerStatus extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:status 
                            {serverName=default : The id of the server to stop}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check the status of a server";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();
        
        if ($this->serverOnline($this->server->name)) {
            $this->comment('Online (tmux:'. prefixedServerName($this->server->name) .')');
            return;
        }

        $this->comment('Offline (tmux:'. prefixedServerName($this->server->name) .')');
    }

}
