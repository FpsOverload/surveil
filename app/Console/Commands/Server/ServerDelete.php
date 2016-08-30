<?php 

namespace App\Console\Commands\Server;

use App\Console\Commands\Command;
use App\Surveil\Servers\ServerManager;
use Illuminate\Support\Facades\App;

class ServerDelete extends Command {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:delete
                            {serverName=default : The id of the server to delete}
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

        if ($this->option('force')) {
            return $this->delete();
        }
        
        if ($this->confirm(trans('servers.delete.confirm', ['server' => $this->server->name]))) {
            return $this->delete();
        }

        $this->comment(trans('servers.delete.aborted'));
    }

    protected function delete()
    {
        $manager = App::make(ServerManager::class, [$this->server]);

        if ($manager->destroy()) {
            return $this->info(trans('servers.delete.success'));
        }
    }

}
