<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Setting;
use App\Services\History\HistoryService;
use App\Services\Room\RoomService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rooms = Room::query();

        if ($keyword = request('search')) {
            $rooms->where('name', 'LIKE', "%{$keyword}%");
        }

        $rooms = $rooms->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showDetails($id)
    {
        $room = Room::find($id);

        return view('admin.rooms.details', compact('room'));
    }
}
