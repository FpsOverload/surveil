<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command as IlluminateCommand;
use App\Exceptions\InvalidServerException;
use App\Server;

class Command extends IlluminateCommand {

    protected $server;

    function __construct(Server $server)
    {
        parent::__construct();

        $this->server = $server;
    }

    protected function serverFromArgument()
    {
        $this->server = Server::where('servers.name', $this->argument('serverName'))->first();

        if (! $this->server) {
            throw new InvalidServerException(trans('servers.not_found', ['server' => $this->argument('serverName')]));
        }

        return;
    }

    protected function collectConfiguration($argument, $else)
    {
        if ($this->argument($argument)) {
            return $this->argument($argument);
        }

        return $else();
    }

}
