<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class ServerPresenter extends Presenter {

    

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
            'port' => $this->entity->port,
            'online' => false
        ]);
    }

}
