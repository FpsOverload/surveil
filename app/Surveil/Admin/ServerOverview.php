<?php

namespace App\Surveil\Admin;

use App\Server;
use App\Surveil\Rcon\RconClient;
use App\Surveil\Servers\ServerIgniter;

class ServerOverview {

    protected $server, $igniter, $rcon;

    function __construct(Server $server)
    {
        $this->server = $server;
        $this->igniter = new ServerIgniter($server);
        $this->rcon = new RconClient($server);
    }

    public function online()
    {
        return $this->igniter->online();
    }

    public function json()
    {
        return json_encode([
            'image' => $this->image(),
            'name' => $this->server->name,
            'game' => $this->server->game,
            'host' => $this->server->ip,
            'port' => $this->server->port,
            'players' => '--',
            'max_players' => '--',
            'map_slug' => $this->online() ? $this->map_slug() : '--',
            'online' => $this->online()
        ]);
    }

    public function map_slug()
    {
        return $this->rcon->connection->map();
    }

    public function image()
    {
        $map_slug = 'default';
        if ($this->map_slug()) {
            $map_slug = $this->map_slug();
        }

        return '/images/games/' . $this->server->game . '/' . $this->server->game . '_' . $map_slug . '.jpg';
    }

}
