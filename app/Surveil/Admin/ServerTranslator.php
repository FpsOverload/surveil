<?php

namespace App\Surveil\Admin;

class ServerTranslator {

    protected $game;

    function __construct($game)
    {
        $this->game = $game;
    }

    function mapName($slug)
    {
        if (config('surveil.maps.' . $this->game . '.' . $slug))
        {
            return config('surveil.maps.' . $this->game . '.' . $slug);
        }

        return $slug;
    }

}
