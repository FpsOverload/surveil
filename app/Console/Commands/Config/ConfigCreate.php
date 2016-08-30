<?php 

namespace App\Console\Commands\Config;

use App\Config;
use App\Configuration;
use App\Console\Commands\Command;
use App\Exceptions\NameExistsException;
use Illuminate\Database\QueryException;

class ConfigCreate extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'config:create
                            {serverName=default : The id of the server to start}
                            {configName? : The name of the config}
                            {configParams? : The server startup parameters}
                            {configSurveil? : Whether to run surveil under this config}
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

        $config['server_id'] = $this->server->id;
        $config['name'] = $this->collectConfiguration($this->argument('configName'), function() { return $this->collectConfigName(); });
        $config['params'] = $this->collectConfiguration($this->argument('configParams'), function() { return $this->ask(trans('servers.create.params')); } );
        $config['surveil'] = $this->collectConfiguration($this->argument('configSurveil'), function() { return $this->ask(trans('servers.create.surveil'), true); } );

        try { 
            Configuration::create($config);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                throw new NameExistsException(trans('servers.config.name_exists', ['name' => $config['name']]));
            }
        }

        $this->info(trans('servers.config.config_created'));
    }

    protected function collectConfigName()
    {
        $configName = $this->ask(trans('servers.config.create.name'));

        if (Configuration::where([['name', $configName], ['server_id', $this->server->id]])->count()) {
            $this->error(trans('servers.config.name_exists_try', ['name' => $configName]));
            return $this->collectConfigName();
        }

        return $configName;
    }

}
