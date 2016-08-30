<?php 

namespace App\Console\Commands\Server;

use App\Console\Commands\Command;
use App\Exceptions\NameExistsException;
use App\Surveil\Servers\ServerManager;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ServerCreate extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:create
                            {name? : A unique name for your server}
                            {path? : Path to the folder of your server}
                            {binary? : Path to the binary (relative to `path`)}
                            {game? : The game the server is running}
                            {ip? : Hostname to connect to the server}
                            {port? : Port to connect to the server}
                            {rcon? : Password to access servers rcon}
                            {params? : Start up parameters for server}
                            {surveil? : Whether to run surveil on server}
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
        $server['name'] = $this->collectConfiguration('name', function() { return $this->collectServerName(); });
        $server['path'] = $this->collectConfiguration('path', function() { return $this->collectPath(); } );
        $server['binary'] = $this->collectConfiguration('binary', function() use ($server) { return $this->collectBinary($server['path']); } );
        $server['game'] = $this->collectConfiguration('game', function() { return $this->choice(trans('servers.create.game'), ['cod4', 'cod4x', 'arma3']); } );
        $server['ip'] = $this->collectConfiguration('ip', function() { return $this->ask(trans('servers.create.ip'), '127.0.0.1'); } );
        $server['port'] = $this->collectConfiguration('port', function() { return $this->ask(trans('servers.create.port')); } );
        $server['rcon'] = $this->collectConfiguration('rcon', function() { return $this->secret(trans('servers.create.rcon')); } );
        $server['default_params'] = $this->collectConfiguration('params', function() { return $this->ask(trans('servers.create.params')); } );
        $server['default_surveil'] = $this->collectConfiguration('surveil', function() { return $this->confirm(trans('servers.create.surveil'), true); } );

        $manager = App::make(ServerManager::class);

        if ($manager->create($server)) {
            $this->info(trans('servers.server_created'));
        }
    }

    protected function collectServerName()
    {
        $default = null;
        if ($this->server->where('servers.name', 'default')->count() == 0) {
            $default = 'default';
        } 

        $serverName = $this->ask(trans('servers.create.name'), $default);

        $validator = Validator::make(['name' => $serverName], ['name' => 'unique:servers']);

        if ($validator->fails()) {
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
