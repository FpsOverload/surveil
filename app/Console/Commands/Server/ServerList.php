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
        $headers = ['Server ID', 'Path', 'Binary', 'IP', 'Port', 'Params'];

        $servers = collect(config('surveil.servers'))->transform(function($server, $id) {
            $server = ['id' => $id] + $server;
            unset($server['server_rcon']);

            return $server;
        });

        $this->table($headers, $servers);
    }

}
