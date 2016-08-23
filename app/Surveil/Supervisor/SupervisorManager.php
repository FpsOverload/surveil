<?php

namespace App\Surveil\Supervisor;

use App\Option;
use App\Server;
use Illuminate\Support\Facades\File;
use Indigo\Ini\Renderer;
use Supervisor\Configuration\Configuration;
use Supervisor\Configuration\Section\Program;
use Symfony\Component\Process\Process;

class SupervisorManager {
    
    public function updateSupervisorConfig()
    {
        $servers = Server::all();

        $config = new Configuration;

        $supervisorPrefix = Option::where('option', 'supervisor_prefix')->firstOrFail()->value;
        $supervisorConfig = Option::where('option', 'supervisor_config')->firstOrFail()->value;

        $servers->each(function($server) use ($config, $supervisorPrefix) {
            $section = new Program($supervisorPrefix . $server->name, $this->optionsForServer($server->name));
            $config->addSection($section);
        });

        $renderer = new Renderer;

        $renderedConfig = $renderer->render($config->toArray());

        if (File::put($supervisorConfig, $renderedConfig) === false)
        {
            return false;
        }

        $this->supervisorUpdate();

        return true;
    }

    public function supervisorProgramForServer($id)
    {
        $supervisorPrefix = Option::where('option', 'supervisor_prefix')->firstOrFail()->value;

        return $supervisorPrefix . $id;
    }

    protected function supervisorUpdate()
    {
        $command = 'supervisorctl reread && supervisorctl update';
        (new Process($command))->setTimeout(null)->run(function($type, $line)
        {
            return $line;
        });
    }

    protected function optionsForServer($serverId)
    {
        $supervisorUser = Option::where('option', 'supervisor_user')->firstOrFail()->value;

        return [
            'autorestart' => false,
            'autostart' => false,
            'command' => base_path('artisan server:start --unsupervised ' . $serverId),
            'directory' => base_path(),
            'user' => $supervisorUser
        ];
    }

}
