<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        App\Server::create([
            'name' => 'default',
            'path' => '/home/oliver/cod4',
            'binary' => 'cod4x18_dedrun',
            'game' => 'cod4',
            'ip' => '127.0.0.1',
            'port' => '28960',
            'rcon' => 'qwertyuiop',
            'default_params' => '+exec server.cfg +map mp_crossfire'
        ]);
    }
}
