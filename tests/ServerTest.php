<?php

use App\Server;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

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
            'serverParams' => '+exec server.cfg +map mp_crossfire',
            'serverSurveil' => true
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
        $server = factory(Server::class)->create();

        $preCount = Server::count();

        Artisan::call('server:delete', [
            'serverName' => $server->name,
            '--force' => true
        ]);

        $output = Artisan::output();

        $this->assertContains('Server deleted', $output);

        $this->assertTrue($preCount > Server::count());
    }

    public function testServerList()
    {
        $server = factory(Server::class)->create();

        Artisan::call('server:list');

        $output = Artisan::output();

        $this->assertContains($server->name, $output);
        $this->assertContains($server->path, $output);
    }

}
