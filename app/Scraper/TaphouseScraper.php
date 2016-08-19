<?php

namespace App\Scraper;

use App\Beer;
use App\Listing;
use App\Scraper\TaplistScraper;

use Symfony\Component\DomCrawler\Crawler;

class TaphouseScraper extends TaplistScraper
{
    /**
     * The url we're crawling.
     *
     * @var string
     */
    protected $url = 'http://taphouse.dk';

    /**
     * Scrape beer data from page.
     */
    public function scrapeListingData(Crawler $crawler)
    {
        $crawler->filter('#beerTable tbody tr')->each(function ($node) {
            $beerdata = array();

            $name = $node->filter('td:nth-child(2)')->each(function ($td) {
                return filter_var($td->text(), FILTER_SANITIZE_STRING);
            });
            if (!$name) {
                return;
            }

            $beerdata['name'] = trim($name[0]);

            $brewery = $node->filter('td:nth-child(4)')->each(function ($td) {
                return filter_var($td->text(), FILTER_SANITIZE_STRING);
            });
            $beerdata['brewery'] = $brewery[0];

            $beer = Beer::firstOrNew($beerdata);

            $node->filter('td:nth-child(9) a')->each(function ($link) use ($beer) {
                $ratebeerurl = $link->attr('href');
                $beer->ratebeerurl = $ratebeerurl;

                $rating = $this->ratebeerScraper->getRatingFromUrl($ratebeerurl);

                if ($rating) {
                    $beer->ratebeeroverallrating = $rating[0];
                }
            });

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
