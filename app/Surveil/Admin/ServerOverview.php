<?php

namespace App\Surveil\Admin;

use App\Server;
use App\Surveil\Servers\ServerIgniter;
use CmdSft\phpRcon\GuestClient;

class ServerOverview {

    protected $server, $igniter, $rcon;

    function __construct(Server $server)
    {
        $this->server = $server;
        $this->igniter = new ServerIgniter($server);
        $this->rcon = new GuestClient($server->game, $server->ip, $server->port);
        $this->translator = new ServerTranslator($server->game);
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
            'players' => $this->online() ? count($this->players()) : '--',
            'max_players' => $this->online() ? $this->max_players() : '--',
            'map_slug' => $this->online() ? $this->map_slug() : '--',
            'map' => $this->online() ? $this->map_name() : '--',
            'online' => $this->online()
        ]);
    }

    public function players()
    {
        return $this->rcon->connection->getPlayers();
    }

    public function max_players()
    {
        return $this->rcon->connection->getMaxPlayers();
    }

    public function map_slug()
    {
        return $this->rcon->connection->getCurrentMap();
    }

    public function map_name()
    {
        return $this->translator->mapName($this->map_slug());
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
