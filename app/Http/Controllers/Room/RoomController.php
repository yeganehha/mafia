<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\PrivateRoomRequest;
use App\Http\Requests\Room\PublicRoomRequest;
use App\Http\Requests\Room\RoomPassRequest;
use App\Models\History;
use App\Models\Member;
use App\Models\Room;
use App\Models\Setting;
use App\Services\History\HistoryService;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createRoom()
    {
        $room = Room::findByUser(auth()->user()->id);
        if ($room) {
            if (!$room->exist)
                return view('rooms.create');
            return redirect()->back()->withErrors(__('messages.room_exist_for_user'));
        }
        return view('rooms.create');
    }

    public function storeRoom(PublicRoomRequest $request, RoomService $roomService, HistoryService $historyService)
    {
        $name = $request->name;
        $type = $request->type;
        $userId = $request->user()->id;

        if ($request->createPrivate) {
            if ($request->customLink) {
                $specialLinkCost = Setting::findByName('special_link_cost');

                $link = $request->customLink;
                $additionalCost = $specialLinkCost->value;
            } else {
                $link = $roomService->generateLink();
                $additionalCost = 0;
            }

            if ($request->passInput) {
                $password = $request->passInput;
            } else {
                $password = null;
            }

            if ($request->joinRequest) {
                $joinRequest = 1;
            } else {
                $joinRequest = 0;
            }
            $room = $roomService->createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest);
            $historyService->saveHistory($room->id, $userId);
        } else {
            $link = $roomService->generateLink();
            $room = $roomService->createPublicRoom($name, $type, $link);
            $historyService->saveHistory($room->id, $userId);
        }
        return redirect(route('home'));
    }

    public function joinRoom(Request $request, RoomService $roomService, HistoryService $historyService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId(auth()->user()->id);

        if ($room->is_private) {
            if ($room->password) {
                return redirect(route('rooms.showPassForm', $room->link));
            } else {
                if (!$member) {
                    $roomService->joinRoom($room->id, auth()->user()->id);
                    $historyService->saveHistory($room->id, $request->user()->id);
                    return redirect(route('home'));
                } else {
                    return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
                }
            }
        } else {
            if (!$member) {
                $roomService->joinRoom($room->id, auth()->user()->id);
                $historyService->saveHistory($room->id, $request->user()->id);
                return redirect(route('home'));
            } else {
                return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
            }
        }
    }

    public function showPassForm(Request $request)
    {
        return view('rooms.room-login');
    }

    public function checkRoomPass(RoomPassRequest $request, RoomService $roomService, HistoryService $historyService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId(auth()->user()->id);

        if ($room->password == $request->password) {
            if (!$member) {
                $roomService->joinRoom($room->id, auth()->user()->id);
                $historyService->saveHistory($room->id, $request->user()->id);
                return redirect(route('home'));
            } else {
                return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
            }
        }
        return redirect(route('rooms.showPassForm', $request->link))->withErrors(['رمز عبور اشتباه است']);
    }

    public function setNotExist(Request $request, RoomService $roomService, HistoryService $historyService)
    {
        $room = Room::findByLink($request->link);
        $history = History::findHistory($room->id, $request->user()->id);

        $roomService->setNotExist($room);
        $this->exitRoom();
        $historyService->setExit($history);

        return redirect()->back();
    }

    public function exitRoom()
    {
        Member::findByUserId(auth()->user()->id)->delete();
        return redirect()->back();
    }
}
