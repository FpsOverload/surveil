<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{

    public function index()
    {
        $servers = Server::all();

        return view('home', compact('servers'));
    }

}
