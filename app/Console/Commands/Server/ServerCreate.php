<?php 

namespace App\Console\Commands\Server;

use App\Exceptions\NameExistsException;
use Illuminate\Database\QueryException;

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
                            {serverSurveil? : Run surveil on server}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new game server";

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
        $server['game'] = $this->collectConfiguration($this->argument('serverGame'), function() { return $this->choice(trans('servers.create.game'), ['cod4', 'cod4x', 'arma3']); } );
        $server['ip'] = $this->collectConfiguration($this->argument('serverIp'), function() { return $this->ask(trans('servers.create.ip'), '127.0.0.1'); } );
        $server['port'] = $this->collectConfiguration($this->argument('serverPort'), function() { return $this->ask(trans('servers.create.port')); } );
        $server['rcon'] = $this->collectConfiguration($this->argument('serverRcon'), function() { return $this->secret(trans('servers.create.rcon')); } );
        $server['params'] = $this->collectConfiguration($this->argument('serverParams'), function() { return $this->ask(trans('servers.create.params')); } );
        $server['surveil'] = $this->collectConfiguration($this->argument('serverSurveil'), function() { return $this->ask(trans('servers.create.surveil'), true); } );

        try { 
            $this->server->create($server);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                throw new NameExistsException(trans('servers.name_exists', ['name' => $server['name']]));
            }
        }

        $this->info(trans('servers.server_created'));
    }

    protected function collectServerName()
    {
        $default = null;

        if ($this->server->where('name', 'default')->count() == 0) {
            $default = 'default';
        } 

        $serverName = $this->ask(trans('servers.create.name'), $default);

        if ($this->server->where('name', $serverName)->count()) {
            $this->error(trans('servers.name_exists_try', ['name' => $serverName]));
            return $this->collectServerName();
        }

        return $serverName;
    }

    protected function collectPath()
    {
        $path = $this->anticipate(trans('servers.create.path'), array_column($this->server->get(['path'])->toArray(), 'path'));

        if (! is_dir($path)) {
            $this->error(trans('servers.invalid_path_try', ['path' => $path]));
            return $this->collectPath();
        }

        return rtrim($path, '/');
    }

    protected function collectBinary($path)
    {
        $binary = $this->anticipate(trans('servers.create.binary'), array_column($this->server->get(['binary'])->toArray(), 'binary'));

        if (! is_file($path . '/' . $binary)) {
            $this->error(trans('servers.invalid_binary_try', ['binary' => $binary]));
            return $this->collectBinary($path);
        }

        return $binary;
    }

}
