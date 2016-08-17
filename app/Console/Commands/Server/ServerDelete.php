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

    protected $server = [];
    protected $serverId = "";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            $server = $this->getServer();

            $this->serverId = $server['serverId'];
            $this->server = $server['config'];
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        if ($this->confirm('Are you sure you wish to delete ' . $this->serverId . '?')) {
            //$this->deleteServer($this->serverId);
        }

        $this->info('Aborted');
    }

}
