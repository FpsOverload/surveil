<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'server_id', 'params', 'surveil'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'surveil' => 'boolean',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
    
}
