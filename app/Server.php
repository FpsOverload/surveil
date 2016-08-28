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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'surveil' => 'boolean',
    ];

    public function configs()
    {
        return $this->hasMany(Ap\Configuration::class);
    }

}
