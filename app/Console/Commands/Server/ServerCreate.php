<?php 

namespace App\Console\Commands\Server;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Indigo\Ini\Renderer;
use Supervisor\Configuration\Configuration;
use Supervisor\Configuration\Section\Program;
use Supervisor\Configuration\Section\Supervisord;

class ServerCreate extends ServerCommand {
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'server:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new game server configuration";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $config = new Configuration;
        $renderer = new Renderer;

        $section = new Program('test', ['command' => 'cat']);
        $config->addSection($section);

        $rendered_config = $renderer->render($config->toArray());

        $bytes_written = File::put('/etc/supervisor/conf.d/test.conf', $rendered_config);
        if ($bytes_written === false)
        {
            die("Error writing to file");
        }

        // dd($this->supervisorInstalled());
        // $serverId = $this->ask('Server ID');
        // $path = $this->ask('path');
        // $binary = $this->ask('binary');
        // $server_ip = $this->ask('server_ip');
        // $server_port = $this->ask('server_port');
        // $server_rcon = $this->ask('server_rcon');
        // $startup_params = $this->ask('startup_params');
    }

}
