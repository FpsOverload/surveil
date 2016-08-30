<?php

namespace App;

use App\Presenters\ServerPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laracasts\Presenter\PresentableTrait;

class Server extends Model
{

    use PresentableTrait;

    protected $presenter = ServerPresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'binary', 'game', 'ip', 'port', 'rcon', 'default_params', 'default_surveil'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'surveil' => 'boolean',
    ];

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);

        $query->select('servers.*', DB::Raw('IFNULL(configurations.params, servers.default_params) as params'), DB::Raw('IFNULL(configurations.surveil, servers.default_surveil) as surveil'));
        $query->LeftJoin('configurations', 'servers.active_config', '=', 'configurations.id');

        return $query;
    }

    public function getPrefixedNameAttribute()
    {
        return prefixedServerName($this->name);
    }

    public function configs()
    {
        return $this->hasMany(Configuration::class);
    }

}
