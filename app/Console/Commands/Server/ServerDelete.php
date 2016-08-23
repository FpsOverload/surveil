<?php 

namespace App\Console\Commands\Server;

class ServerDelete extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:delete
                            {serverName=default : The id of the server to delete}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Delete a game server configuration";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->getServer();

        if ($this->confirm('Are you sure you wish to delete ' . $this->serverName . '?')) {
            $this->deleteServer($this->serverName);

            $this->info("Server deleted");

            return;
        }

        $this->info('Aborted');
    }

}
