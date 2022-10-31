<?php

namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\PrivateRoomRequest;
use App\Http\Requests\Room\PublicRoomRequest;
use App\Http\Requests\Room\RoomPassRequest;
use App\Models\Member;
use App\Models\Room;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createPublic(PublicRoomRequest $request, RoomService $roomService)
    {
        $name = $request->name;
        $type = $request->type;
        try {
            $link = $roomService->generateLink();
            if ($roomService->createPublicRoom($name, $type, $link))
                return $this->response(true, 'اتاق عمومی با موفقیت ایجاد شد');
            return $this->response(false, 'اتاق عمومی ایجاد نشد', [], 403);
        } catch (\Exception $exception) {
            return $this->response(false, $exception, [], 503);
        }
    }

    public function createPrivate(PrivateRoomRequest $request, RoomService $roomService)
    {
        $name = $request->name;
        $type = $request->type;
        try {
            if ($request->customLink) {
                $link = $request->customLink;
                $additionalCost = 1;
            } else {
                $link = $roomService->generateLink();
                $additionalCost = 0;
            }

            if ($request->password) {
                $password = $request->password;
            } else {
                $password = null;
            }

            if ($request->joinRequest) {
                $joinRequest = 1;
            } else {
                $joinRequest = 0;
            }
            if ($roomService->createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest))
                return $this->response(true, 'اتاق خصوصی با موفقیت ایجاد شد');
            return $this->response(false, 'اتاق خصوصی ایجاد نشد', [], 403);
        } catch (\Exception $exception) {
            return $this->response(false, $exception, [], 503);
        }
    }

    public function all()
    {
        try {
            $rooms = Room::all();
            if ($rooms->count())
                return $this->response(true, 'لیست تمام اتاق ها', [$rooms]);
            return $this->response(false, 'اتاقی یافت نشد', [], 404);
        } catch (\Exception $exception) {
            return $this->response(false, $exception, [], 503);
        }
    }

    public function joinRoom(Request $request, RoomService $roomService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId($request->user()->id);

        if ($room->is_private) {
            if ($room->password) {
                return $this->response(true, 'رمز عبور اتاق را وارد کنید');
            } else {
                if (!$member) {
                    $roomService->joinRoom($room->id, $request->user()->id);
                    return $this->response(true, 'با موفقیت عضو شدید');
                } else {
                    return $this->response(false, 'از قبل عضو یک اتاق هستید', [], 406);
                }
            }
        } else {
            if (!$member) {
                $roomService->joinRoom($room->id, $request->user()->id);
                return $this->response(true, 'با موفقیت عضو شدید');
            } else {
                return $this->response(false, 'از قبل عضو یک اتاق هستید', [], 406);
            }
        }
    }

    public function checkRoomPass(RoomPassRequest $request, RoomService $roomService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId($request->user()->id);

        if ($room->password == $request->password) {
            if (!$member) {
                $roomService->joinRoom($room->id, $request->user()->id);
                return $this->response(true, 'با موفقیت عضو شدید');
            } else {
                return $this->response(false, 'از قبل عضو یک اتاق هستید', [], 406);
            }
        }
        return $this->response(false, 'رمز عبور اشتباه است', [], 406);
    }
}
