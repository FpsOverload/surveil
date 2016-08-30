<?php 

namespace App\Console\Commands\Server;

use Symfony\Component\Console\Helper\TableStyle;

class ServerStatus extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check the status of your game servers";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $tableStyle = new TableStyle();
        $tableStyle->setCellHeaderFormat('<fg=yellow>%s</>');

        $servers = $this->server->all()->transform(function ($item, $key) {
            $item = collect($item)->only(['name', 'path', 'binary', 'game', 'ip', 'port', 'params', 'surveil']);
            $item['surveil'] = $item['surveil'] ? 'Enabled' : 'Disabled';
            //$item['status'] = $this->serverOnline($item['name']) ? '<fg=blue>Online</>' : '<fg=red>Offline</>';
            return $item;
        });

        $this->table(
            ['Name', 'Path', 'Binary', 'Game', 'IP', 'Port', 'Active Params', 'Surveil', 'Status'], 
            $servers, 
            $tableStyle
        );
    }

}
