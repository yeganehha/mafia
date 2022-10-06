<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        auth()->loginUsingId(1);
        $rooms = Room::all();
        return view('home', compact('rooms'));
    }
}
