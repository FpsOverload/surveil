<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ServerPresenter extends Presenter {

    public function map_slug()
    {
        return null;
    }

    public function image()
    {
        $map_slug = 'default';
        if ($this->map_slug) {
            $map_slug = $this->map_slug;
        }

        return '/images/games/' . $this->entity->game . '/' . $this->entity->game . '_' . $map_slug . '.jpg';
    }

    public function address()
    {
        return $this->entity->ip . ':' . $this->entity->port;
    }

    public function json()
    {
        return json_encode([
            'image' => $this->image,
            'name' => $this->entity->name,
            'game' => $this->entity->game,
            'address' => $this->address,
            'host' => $this->entity->ip,
            'port' => $this->entity->port
        ]);
    }

}
