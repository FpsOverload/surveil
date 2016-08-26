<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServerStart extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:start 
                            {serverName=default : The id of the server to start}
                            {--s|live : Start the server manually without a tmux session}
                        ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start a game server";

    protected $gameCommand = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();
        $this->buildCommand();
        
        if ($this->option('live')) {
            return $this->startLiveServer();
        }

        return $this->startTmuxServer();
    }

    protected function buildCommand()
    {
        $this->gameCommand = 'cd ' . $this->server->path . ' && ./' . $this->server->binary . ' ' . $this->server->params;
    }

    protected function startTmuxServer()
    {
        $command = 'tmx new-session -d -s "' . $this->server->name . '" "' . $this->gameCommand . '" 2> ' . storage_path('logs/' . $this->server->name .'-error.log');

        $process = new Process($command);
        $process->setTimeout(10);
        $process->run();

        $this->info($command);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // $this->info($process->getOutput());
    }

    protected function startLiveServer()
    {
        (new Process($this->gameCommand))->setTimeout(null)->run(function($type, $line)
        {
            $this->info($line);
        });
    }

}
