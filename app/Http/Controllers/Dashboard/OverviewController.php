<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OverviewController extends Controller
{

    function __construct()
    {
        $this->middleware(['admin']);
    }
    
    public function index()
    {

    }

}
