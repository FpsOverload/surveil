<?php 

namespace App\Console\Commands\Server;

class ServerCreate extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new game server configuration";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info($this->supervisor->updateSupervisorConfig());

        // dd($this->supervisorInstalled());
        // $serverId = $this->ask('Server ID');
        // $path = $this->ask('path');
        // $binary = $this->ask('binary');
        // $server_ip = $this->ask('server_ip');
        // $server_port = $this->ask('server_port');
        // $server_rcon = $this->ask('server_rcon');
        // $startup_params = $this->ask('startup_params');
    }

}
