<?php

namespace App\Http\Controllers;

use App\Server;
use App\Surveil\Admin\ServerOverview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{

    public function index()
    {
        $servers = Server::all()->transform( function($item) {
            return new ServerOverview($item);
        });

        return view('home', compact('servers'));
    }

}
