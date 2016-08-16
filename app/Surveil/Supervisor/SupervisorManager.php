<?php

namespace App\Surveil\Supervisor;

class SupervisorManager {
    
    public function updateSupervisorConfig()
    {
        $serverConfig = collect(config('surveil.servers'));

        $serverConfig->each(function($key, $value) {

        });

        return "Updated supervisor config";

        // $config = new Configuration;
        // $renderer = new Renderer;

        // $section = new Program('test', ['command' => 'cat']);
        // $config->addSection($section);

        // $rendered_config = $renderer->render($config->toArray());

        // $bytes_written = File::put('/etc/supervisor/conf.d/test.conf', $rendered_config);
        // if ($bytes_written === false)
        // {
        //     die("Error writing to file");
        // }
    }

}
