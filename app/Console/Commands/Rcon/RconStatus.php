<?php 

namespace App\Console\Commands\Rcon;

class RconStatus extends RconCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'rcon:status
                            {serverId=default : The id of the server to send the command}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get the status of a specified server";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        //$this->connectToServer();
    }

}
