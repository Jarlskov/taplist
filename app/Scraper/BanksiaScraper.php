<?php

namespace App\Scraper;

use App\Beer;
use App\Listing;

use Symfony\Component\DomCrawler\Crawler;

class BanksiaScraper extends TaplistScraper
{
    /**
     * The url to scrape.
     */
    protected $url = 'http://banksia.dk/en';

    /**
     * Scrape beer data from page.
     */
    public function scrapeListingData(Crawler $crawler)
    {
        $table = $crawler->filter('div[data-name="menu-beer"] .menu-content .menu-items:nth-child(1)')->first();

        $table->filter('td.text-description')->each(function ($node) {
            $beerdata = array();

            $title = explode('. ', $node->filter('h4')->first()->text(), 2);
            if (count($title) < 2) {
                return;
            }
            $tapname = $title[0];

            $beerdata['name'] = trim(filter_var($title[1], FILTER_SANITIZE_STRING));;

            $info = explode('/', $node->filter('.text-primary')->first()->text());
            $beerdata['brewery'] = trim(filter_var($info[0], FILTER_SANITIZE_STRING));

            $beer = Beer::firstOrCreate($beerdata);

            $rating = $this->ratebeerScraper->getRatingForBeer($beer);
            if ($rating) {
                $beer->ratebeeroverallrating = $rating[0];
            }
            
            $beer->save();

            $listingdata = array(
                'bar_id' => $this->bar->id,
                'beer_id' => $beer->id, 
                'tap_name' => $tapname,
            );
            $listing = Listing::firstOrCreate($listingdata);
            $listing->is_available = true;
            $listing->save();
        });
    }
}
