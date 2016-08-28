<?php 

namespace App\Console\Commands\Config;

use App\Config;
use App\Configuration;
use App\Exceptions\InvalidServerException;
use App\Exceptions\NameExistsException;
use Illuminate\Database\QueryException;

class ConfigDelete extends ConfigCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'config:delete
                            {configName : The name of the config}
                            {serverName=default : The id of the server to start}
                            {--f|force : Delete the server without confirmation}
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Delete a game server configuration";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->serverFromArgument();

        $config = $this->server->configs()->where('name', $this->argument('configName'))->first();

        if (! $config) {
            throw new InvalidServerException(trans('servers.config.not_found_for', ['name' => $this->argument('configName'), 'server' => $this->server->name]));
        }

        if ($this->option('force')) {
            return $this->delete($config);
        }

        if ($this->confirm(trans('servers.config.delete.confirm', ['name' => $config->name, 'server' => $this->server->name]))) {
            return $this->delete($config);
        }

        $this->comment(trans('servers.config.delete.aborted'));
    }

    protected function delete($config)
    {
        $config->delete();

        $this->info(trans('servers.config.delete.success'));

        return;
    }

}
