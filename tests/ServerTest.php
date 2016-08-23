<?php

use App\Server;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ServerTest extends TestCase
{
    use DatabaseTransactions;

    public function testServerCreation()
    {
         Artisan::call('server:create', [
            'serverName' => 'myServer',
            'serverPath' => '/home/oliver/cod4',
            'serverBinary' => 'cod4x_dedrun',
            'serverGame' => 'cod4x',
            'serverIp' => '127.0.0.1',
            'serverPort' => '28960',
            'serverRcon' => 'qwertyuiop',
            'serverParams' => '+exec server.cfg +map mp_crossfire'
        ]);

        $this->seeInDatabase('servers', [
            'name' => 'myServer',
            'path' => '/home/oliver/cod4',
            'binary' => 'cod4x_dedrun',
            'game' => 'cod4x',
            'ip' => '127.0.0.1',
            'port' => '28960',
            'rcon' => 'qwertyuiop',
            'params' => '+exec server.cfg +map mp_crossfire'
        ]);
    }

    public function testServerDeletion()
    {
        $this->testServerCreation();

        $preCount = Server::count();

        Artisan::call('server:delete', [
            'serverName' => 'myServer',
            '--force' => true
        ]);

        $output = Artisan::output();

        $this->assertContains('Server deleted', $output);

        $this->assertTrue($preCount > Server::count());
    }
}
