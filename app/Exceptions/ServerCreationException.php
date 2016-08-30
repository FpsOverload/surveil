<?php

namespace App\Exceptions;

class ServerCreationException extends \Exception {

    public function __construct($messages)
    {
        $messages = collect($messages->all())->transform(function ($message) {
            return " * " . $message;
        });

        $this->message = implode("\n", $messages->toArray());
    }

}
