<?php

namespace App\Surveil\Supervisor;

class SupervisorManager {
    
    public function updateSupervisorConfig()
    {
        $serverConfig = collect(config('servers.servers'));
    }

}
