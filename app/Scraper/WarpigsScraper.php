<?php

namespace App\Scraper;

use App\Beer;
use App\Listing;
use App\Scraper\TaplistScraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class WarpigsScraper extends TaplistScraper
{
    /**
     * The url we're scraping.
     *
     * @var string
     */
    protected $url = 'http://warpigs.dk/eat-drink/';

    /**
     * Scrape page for beer data.
     */
    public function scrapeListingData(Crawler $crawler)
    {
        $crawler->filter('.colcount-1 tr')->each(function ($node) {
            $beerdata = array();

            $name = $node->filter('td:nth-child(2)')->each(function($td) {
                return filter_var($td->text(), FILTER_SANITIZE_STRING);
            });
            if (!$name || strpos($name[0], ':') === false) {
                return;
            }

            list($brewery, $name) = explode(': ', $name[0]);

            $beerdata['name'] = trim($name);
            $beerdata['brewery'] = trim($brewery);
            
            $beer = Beer::firstOrNew($beerdata);

            $rating = $this->ratebeerScraper->getRatingForBeer($beer);
            if ($rating) {
                $beer->ratebeeroverallrating = $rating[0];
            }

            $beer->save();

            $listingdata = array(
                'bar_id' => $this->bar->id,
                'beer_id' => $beer->id,
            );

            $listing = Listing::firstOrNew($listingdata);
            $listing->is_available = true;

            $node->filter('td:nth-child(1)')->each(function ($node) use ($listing) {
                $listing->tap_name = filter_var($node->text(), FILTER_SANITIZE_STRING);
            });

            $listing->save();
        });
    }
}
