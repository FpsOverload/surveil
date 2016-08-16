<?php namespace App\Console\Commands;

use App\Exceptions\InvalidServerException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class ServerStart extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:start 
                            {serverId? : The server to start}
                            {--s|surveil : Whether surveil should also start}
                            {--S|screen : Run server inside a screen}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start game server";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {

        try {
            $server = $this->getServer();
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }
        
        if ($this->option('screen')) {

            $command = "screen -options..";

            $process = new Process();

        } else {

            // new GameProcessor..

            $path = "";
            $command = "cd /home/oliver/cod4/ && ./cod4x18_dedrun +exec server.cfg +map mp_crossfire";

            // (new Process($command))->setTimeout(null)->run(function($type, $line) use ($output)
            // {
            //     $output->write("Line: " . $line);
            // });

        }

        dd($this->getOutput()->getVerbosity());
        
    }

    private function getServer()
    {

        $config = config('servers.servers.default');

        if ($this->argument('serverId')) {
            $config = config('servers.servers.' . $this->argument('serverId'));
        }

        if (!$config) {
            throw new InvalidServerException("Server not found");
        }

        return $config;

    }

}
