<?php 

namespace App\Console\Commands\Server;

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
                            {serverId? : The id of the server to start}
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
        try {
            $server = $this->getServer();
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
        // Call supervisor start for server id..
        // $path = "";
        // $command = "cd /home/oliver/cod4/ && ./cod4x18_dedrun +exec server.cfg +map mp_crossfire";

        // (new Process($command))->setTimeout(null)->run(function($type, $line) use ($output)
        // {
        //     $output->write("Line: " . $line);
        // });
    }

    protected function startUnsupervisedServer()
    {
        // Get the command, cd, run, etc..
        // $command = "screen -options..";
        // $process = new Process();
    }

}
