<?php

namespace App;

use App\Bar;
use Illuminate\Support\Collection;

class TaplistService
{
    protected $bars;

    public function __construct()
    {
        $this->bars = Bar::all();
    }

    public function updateTaplists()
    {
        $beers = new Collection();

        foreach ($this->bars as $bar) {
            $beers = $beers->merge($this->update($bar));
        }

        return $beers;
    }

    public function update($bar)
    {
        $scraper = $bar->getScraper();

        return $scraper->scrape();
    }
}
