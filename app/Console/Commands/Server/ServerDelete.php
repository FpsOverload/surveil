<?php 

namespace App\Console\Commands\Server;

class ServerDelete extends ServerCommand {
    
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
        
        if ($this->confirm('Are you sure you wish to delete ' . $this->server->name . '?')) {
            return $this->delete();
        }

        $this->info('Aborted');
    }

    protected function delete()
    {
        $this->server->delete();

        $this->info("Server deleted");

        return;
    }

}
