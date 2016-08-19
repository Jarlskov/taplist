<?php

namespace App\Scraper;

use Goutte\Client;

class RatebeerScraper
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a beer's overall rating from it's ratebeer URL.
     *
     * @param string $url
     *
     * @return array<int>
     */
    public function getRatingFromUrl($url)
    {
        $scraper = $this->client->request('GET', $url);

        return $scraper->filter('#_aggregateRating6 span[itemprop=ratingValue]')->each(function ($span) {
            return $span->text();
        });
    }
}
