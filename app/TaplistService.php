<?php

namespace App;

use App\Bar;
use Illuminate\Support\Collection;

class TaplistService
{
    /**
     * Update taplists for all bars.
     */
    public function updateTaplists()
    {
        Bar::all()->each(function($bar) {
            $bar->updateTaplist();
        });
    }
}
