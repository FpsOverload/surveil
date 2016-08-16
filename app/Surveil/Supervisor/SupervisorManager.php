<?php

namespace App\Surveil\Supervisor;

use Illuminate\Support\Facades\File;
use Indigo\Ini\Renderer;
use Supervisor\Configuration\Configuration;
use Supervisor\Configuration\Section\Program;

class SupervisorManager {
    
    public function updateSupervisorConfig()
    {
        $servers = collect(config('surveil.servers'));

        $config = new Configuration;

        $servers->each(function($server, $id) use ($config) {
            $section = new Program(config('surveil.supervisor_prefix') . $id, $this->optionForServer($server));
            $config->addSection($section);
        });

        $renderer = new Renderer;

        $renderedConfig = $renderer->render($config->toArray());

        if (File::put(config('surveil.supervisor_config'), $renderedConfig) === false)
        {
            return false;
        }

        return true;
    }

    protected function optionForServer($server)
    {
        return [
            'autorestart' => false,
            'autostart' => false,
            'command' => "\"./" . $server['binary'] . " " . $server['startup_params'] . '"',
            'directory' => '"' . $server['path'] . '"',
            'user' => config('surveil.supervisor_user')
        ];
    }

}
