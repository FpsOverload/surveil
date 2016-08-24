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
        DB::table('options')->insert([
            ['option' => 'supervisor_prefix', 'value' => 'surveil_'],
            ['option' => 'supervisor_user', 'value' => 'oliver'],
            ['option' => 'supervisor_config', 'value' => '/etc/supervisor/conf.d/surveil.conf']
        ]);
    }
}
