<?php 

namespace App\Console\Commands\Server;

class ServerDelete extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:delete
                            {serverId? : The id of the server to start}
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
        try {
            $this->server = $this->getServer();
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $serverId = $this->argument('serverId');

        if ($this->confirm('Are you sure you wish to delete ' . $serverId . '?')) {
            //$this->deleteServer($serverId);
        }

        $this->info('Aborted');
    }

}
