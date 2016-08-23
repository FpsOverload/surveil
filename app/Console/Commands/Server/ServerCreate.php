<?php 

namespace App\Console\Commands\Server;

class ServerCreate extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:create
                            {serverName? : The server name}
                            {serverPath? : The server path}
                            {serverBinary? : The server binary}
                            {serverGame? : The server game}
                            {serverIp? : The server ip}
                            {serverPort? : The server port}
                            {serverRcon? : The server rcon}
                            {serverParams? : The server params}
                        ';

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
        $server['name'] = $this->collectConfiguration($this->argument('serverName'), function() { return $this->collectServerName(); });
        $server['path'] = $this->collectConfiguration($this->argument('serverPath'), function() { return $this->collectPath(); } );
        $server['binary'] = $this->collectConfiguration($this->argument('serverBinary'), function() use ($server) { return $this->collectBinary($server['path']); } );
        $server['game'] = $this->collectConfiguration($this->argument('serverGame'), function() { return $this->choice('Server Game', ['cod4', 'cod4x', 'arma3']); } );
        $server['ip'] = $this->collectConfiguration($this->argument('serverIp'), function() { return $this->ask('Server IP', '127.0.0.1'); } );
        $server['port'] = $this->collectConfiguration($this->argument('serverPort'), function() { return $this->ask('Server Port'); } );
        $server['rcon'] = $this->collectConfiguration($this->argument('serverRcon'), function() { return $this->secret('Server Rcon Password'); } );
        $server['params'] = $this->collectConfiguration($this->argument('serverParams'), function() { return $this->ask('Server Startup Parameters'); } );

        $this->createServer($server);
    }

    protected function collectConfiguration($argument, $else)
    {
        if ($argument) {
            return $argument;
        }

        $else();
    }

    protected function collectServerName()
    {
        $default = null;

        if ($this->server->where('name', 'default')->count() == 0) {
            $default = 'default';
        } 

        $serverName = $this->ask('Server Name', $default);

        if ($this->server->where('name', $serverName)->count()) {
            $this->error('Server id taken, try again');
            return $this->collectServerName();
        }

        return $serverName;
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
