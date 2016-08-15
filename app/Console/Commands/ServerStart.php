<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class ServerStart extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:start 
                            {--s|surveil : Whether surveil should also start}';

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
        $path = base_path('sample_log.log');

        $output = $this->output;

        (new Process('/home/oliver/cod4/cod4x18_dedrun +exec server.cfg +map mp_crossfire'))->setTimeout(null)>run(function($type, $line) use ($output)
        {
            $output->write("Line: " . $line);
        });

        // (new Process('tail -f '.escapeshellarg($path)))->setTimeout(null)->run(function($type, $line) use ($output)
        // {
        //     $output->write("Line: " . $line);
        // });

        
    }
}
