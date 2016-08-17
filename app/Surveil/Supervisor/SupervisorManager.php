<?php

namespace App\Surveil\Supervisor;

use Illuminate\Support\Facades\File;
use Indigo\Ini\Renderer;
use Supervisor\Configuration\Configuration;
use Supervisor\Configuration\Section\Program;
use Symfony\Component\Process\Process;

class SupervisorManager {
    
    public function updateSupervisorConfig()
    {
        $servers = collect(config('surveil.servers'));

        $config = new Configuration;

        $servers->each(function($server, $id) use ($config) {
            $section = new Program(config('surveil.supervisor_prefix') . $id, $this->optionForServer($server, $id));
            $config->addSection($section);
        });

        $renderer = new Renderer;

        $renderedConfig = $renderer->render($config->toArray());

        if (File::put(config('surveil.supervisor_config'), $renderedConfig) === false)
        {
            return false;
        }

        $this->supervisorUpdate();

        return true;
    }

    public function supervisorProgramForServer($id)
    {
        return config('surveil.supervisor_prefix') . $id;
    }

    protected function supervisorUpdate()
    {
        $command = 'supervisorctl reread && supervisorctl update';
        (new Process($command))->setTimeout(null)->run(function($type, $line)
        {
            return $line;
        });
    }

    protected function optionForServer($server, $id)
    {
        return [
            'autorestart' => false,
            'autostart' => false,
            'command' => base_path('artisan server:start --unsupervised ' . $id),
            'directory' => base_path(),
            'user' => config('surveil.supervisor_user')
        ];
    }

}
