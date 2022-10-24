<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RoomInfo extends Component
{
    public $member;
    public $room;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($member, $room)
    {
        $this->member = $member;
        $this->room = $room;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.room-info');
    }
}
