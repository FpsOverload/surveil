<?php

namespace App\Surveil\Servers;

use App\Exceptions\ServerOfflineException;
use App\Exceptions\ServerOnlineException;
use App\Server;
use Symfony\Component\Process\Process;

class ServerIgniter {

    /* 
     * Instance of App\Server
     */
    protected $server;

    function __construct(Server $server)
    {
        $this->server = $server;
    }

    /*
     * Start the game server.
     */
    public function start()
    {
        if ($this->online()) {
            throw new ServerOnlineException($this->server);
        }

        $process = new Process('tmux new-session -d -s "' . $this->server->prefixed_name . '" "' . $this->startCommand() . '" 2> ' . logPath($this->server->name, 'error'));
        $process->setTimeout(10);
        $process->run();

        if (! $this->online()) {
            throw new CommandFailedException($this->server);
        }

        return true;
    }

    /*
     * Stop the game server.
     */
    public function stop()
    {
        if (! $this->online()) {
            throw new ServerOfflineException($this->server);
        }

        $process = new Process('tmux kill-session -t "' . $this->server->prefixed_name . '"');
        $process->setTimeout(10);
        $process->run();

        if ($this->online()) {
            throw new CommandFailedException($this->server);
        }

        return true;
    }

    public function online()
    {
        $process = new Process('tmux list-sessions 2>&1 | awk "{print $1}" | grep -Ec "' . $this->server->prefixed_name. ':"');
        $process->run();

        return boolval(rtrim($process->getOutput()));
    }

    /*
     * Restart the game server.
     */
    public function restart()
    {
        $this->stop();
        return $this->start();
    }

    public function startCommand()
    {
        return 'cd ' . $this->server->path . ' && ./' . $this->server->binary . ' ' . $this->server->params;
    }

}
