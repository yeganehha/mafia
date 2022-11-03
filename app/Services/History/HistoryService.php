<?php

namespace App\Services\History;

use App\Models\History;

class HistoryService
{

    public function saveHistory($roomId, $userId)
    {
        $history = new History();
        $history->saveHistory($roomId, $userId);
    }

    public function setExit($roomHistory)
    {
        $history = new History();
        $history->setExit($roomHistory);
    }
}
