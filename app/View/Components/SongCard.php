<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SongCard extends Component
{
    public $song;

    public function __construct($song)
    {
        $this->song = $song;
    }

    public function render(): View|Closure|string
    {
        return view('components.song-card');
    }
}
