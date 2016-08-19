<?php

namespace App;

use App\Scraper\RatebeerScraper;

use Goutte\Client;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    /**
     * Update the Bar's taplist.
     */
    public function updateTaplist()
    {
        $this->getScraper()->scrape();
    }

    /**
     * Get the Bar's scraper.
     *
     * @return App\Scraper
     */
    public function getScraper()
    {
        $class = "App\\Scraper\\{$this->scraperclass}";
        return new $class($this, new RatebeerScraper(new Client()));
    }
}
