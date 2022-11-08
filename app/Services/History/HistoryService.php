<?php

namespace App\Services\History;

use App\Models\History;

class HistoryService
{

    public function saveHistory($roomId, $userId, $agent, $ip, $description)
    {
        $history = new History();
        $history->saveHistory($roomId, $userId, $agent, $ip, $description);
    }
}
