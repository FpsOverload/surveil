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
        $serverId = $this->collectServerId();

        $server['path'] = $this->collectPath();
        $server['binary'] = $this->collectBinary($server['path']);
        $server['server_ip'] = $this->ask('server_ip');
        $server['server_port'] = $this->ask('server_port');
        $server['server_rcon'] = $this->ask('server_rcon');
        $server['startup_params'] = $this->ask('startup_params');

        $this->addServer($server, $serverId);
    }

    protected function collectServerId()
    {
        $default = null;
        
        if (empty(config('surveil.servers'))) {
            $default = 'default';
        } 

        $serverId = $this->ask('Server ID', $default);

        if (config('surveil.servers.' . $serverId)) {
            $this->error('Server id taken, try again');
            return $this->collectServerId();
        }

        return $serverId;
    }

    protected function collectPath()
    {
        $path = $this->ask('Binary directory, do not include the binary name');

        if (! is_dir($path)) {
            $this->error('Please enter a valid path');
            return $this->collectPath();
        }

        return rtrim($path, '/');
    }

    protected function collectBinary($path)
    {
        $binary = $this->ask('Binary name');

        if (! is_file($path . '/' . $binary)) {
            $this->error('Please enter a valid binary');
            return $this->collectBinary($path);
        }

        return $binary;
    }

}
