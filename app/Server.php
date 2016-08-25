<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'binary', 'game', 'ip', 'port', 'rcon', 'params', 'surveil'
    ];

}
