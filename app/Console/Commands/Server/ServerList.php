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
        $headers = ['Name', 'Path', 'Binary', 'Game', 'IP', 'Port', 'Params', 'Status'];
        $servers = $this->server->get(['name', 'path', 'binary', 'game', 'ip', 'port', 'params']);

        $servers->transform(function ($value) {
            $value->status = $this->serverOnline($value['name']) ? 'Online' : 'Offline';

            return $value;
        });

        $this->table($headers, $servers);
    }

}
