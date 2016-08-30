<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\CommandFailedException;
use App\Exceptions\InvalidServerException;
use App\Exceptions\ProcessFailedException;
use App\Surveil\Servers\ServerIgniter;
use Symfony\Component\Process\Process;

class ServerStart extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:start 
                            {serverName=default : The id of the server to start}
                            {configName? : Start server with specifiec configuration}
                            {--s|live : Start the server manually without a tmux session}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start a game server";

    protected $serverIgniter;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();
        $this->serverIgniter = new ServerIgniter($this->server);
        
        if ($this->option('live')) {
            return $this->startLiveServer();
        }

        return $this->startTmuxServer();
    }

    protected function startTmuxServer()
    {
        if ($this->serverIgniter->start()) {
            return $this->info('Server "' . $this->server->name . '" started');
        }
    }

    protected function startLiveServer()
    {
        (new Process($this->serverIgniter->startCommand()))->setTimeout(null)->run(function($type, $line)
        {
            $this->info($line);
        });
    }

}
