<?php 

namespace App\Console\Commands\Config;

use App\Config;
use App\Exceptions\NameExistsException;
use Illuminate\Database\QueryException;

class ConfigCreate extends ConfigCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'config:create
                            {serverName? : Server you wish to add config to}
                            {configName? : The name of the config}
                            {serverParams? : The server startup parameters}
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
        $this->serverFromArgument();

        $server['server_id'] = $this->server->id;
        $server['name'] = $this->collectConfiguration($this->argument('serverName'), function() { return $this->collectConfigName(); });
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

    protected function collectConfigName()
    {
        $configName = $this->ask(trans('servers.config.create.name'));

        if (Config::where('name', $configName)->count()) {
            $this->error(trans('servers.config.name_exists_try', ['name' => $configName]));
            return $this->collectConfigName();
        }

        return $configName;
    }

}
