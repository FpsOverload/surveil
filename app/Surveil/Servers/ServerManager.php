<?php

namespace App\Surveil\Servers;

use App\Server;
use Illuminate\Support\Facades\Validator;

class ServerManager {

    protected $server, $validator;

    /* 
     * Initialize ServerIgniter
     */
    function __construct(Server $server, ServerValidator $validator)
    {
        $this->server = $server;
        $this->validator = $validator;
    }

    public function create($input)
    {
        $input['default_surveil'] = boolval($input['default_surveil']);

        if ($this->validator->validateCreate($input)) {
            $this->server->create($input);
            
            return true;
        }

        return false;
    }

    public function destroy()
    {

    }

    public function update()
    {

    }

}
