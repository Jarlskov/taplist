<?php

namespace App\Scraper;

use App\Beer;
use App\Listing;

use Symfony\Component\DomCrawler\Crawler;

class FermentorenScraper extends TaplistScraper
{
    /**
     * The URL to scrape.
     *
     * @var string
     */
    protected $url = 'http://fermentoren.com';

    /**
     * Scrape the website content for data.
     */
    public function scrapeListingData(Crawler $crawler)
    {
        $crawler->filter('.home_content_contain a')->each(function ($node) use ($crawler) {
            $beerData = array();

            $ratebeerurl = $node->attr('href');
            $ratebeerScraper = $this->client->request('GET', $ratebeerurl);

            $beerData['name'] = $ratebeerScraper->filter('.user-header h1')->first()->text();
            $beerData['brewery'] = $ratebeerScraper->filter('#_brand4 span')->first()->text();

            $beer = Beer::firstOrCreate($beerData);

            $beer->ratebeerurl = $ratebeerurl;
            $rating = $this->ratebeerScraper->getRatingFromCrawler($ratebeerScraper);
            if ($rating) {
                $beer->ratebeeroverallrating = $rating[0];
            }

            $beer->save();

            $tapName = $node->filter('span b')->first()->text();
            $tapName = explode(')', $tapName)[0];

            $listingData = array(
                'bar_id' => $this->bar->id,
                'beer_id' => $beer->id, 
                'tap_name' => $tapName,
            );

            $listing = Listing::firstOrCreate($listingData);
            $listing->is_available = true;
            $listing->save();
        });
    }
}
