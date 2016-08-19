<?php

namespace App;

use App\Scraper\RatebeerScraper;

use Goutte\Client;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    public function getScraper()
    {
        $class = "App\\Scraper\\{$this->scraperclass}";
        return new $class($this, new RatebeerScraper(new Client()));
    }
}
