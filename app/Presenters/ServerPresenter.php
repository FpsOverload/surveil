<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ServerPresenter extends Presenter {

    public function image()
    {
        return '/images/games/' . $this->entity->game . '/' . $this->entity->game . '_tanoa.jpg';
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
