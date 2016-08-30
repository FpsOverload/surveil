<?php

namespace App\Surveil\Servers;

use App\Server;
use Illuminate\Support\Facades\Validator;

class ServerManager {

    /* 
     * Instance of App\Server
     */
    protected $server;

    /* 
     * Initialize ServerIgniter
     */
    function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function create()
    {

    }

    public function destroy()
    {

    }

    public function update()
    {

    }

    protected function validate($input, $rules)
    {
        Validator::make($input, $rules);
    }

}
