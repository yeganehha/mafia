<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Room;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $member = Member::where('user_id', auth()->user()->id)->first();
        if ($member) {
            $room = Room::find($member->room_id);
        } else {
            $room = null;
        }
        return view('home', compact(['room', 'member']));
    }
}
