<?php 

namespace App\Console\Commands\Server;

class ServerList extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List game servers";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $headers = ['Name', 'Path', 'Binary', 'Game', 'IP', 'Port', 'Params'];

        $this->table($headers, $this->server->get(['name', 'path', 'binary', 'game', 'ip', 'port', 'params']));
    }

}
