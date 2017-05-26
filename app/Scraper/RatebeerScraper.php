<?php

namespace App\Scraper;

use App\Beer;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class RatebeerScraper
{
    /**
     * Scraper client.
     *
     * @var Goutte\Client
     */
    protected $client;

    /**
     * The Ratebeer base url.
     *
     * @var string
     */
    protected $baseUrl = 'http://www.ratebeer.com';

    /**
     * Base url for searching.
     *
     * @var string
     */
    protected $searchUrl = 'http://www.ratebeer.com/findbeer.asp?beername=';

    /**
     * Constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a beer's overall rating.
     *
     * @return array<int>
     */
    public function getRatingForBeer(Beer $beer)
    {
        if ($beer->ratebeerurl === '') {
            $this->setBeerUrl($beer);
        }

        return $this->getRatingFromUrl($beer->ratebeerurl);
    }

    /**
     * Find and save a beer's URL.
     */
    public function setBeerUrl(Beer $beer)
    {
        $searchurl = $this->searchUrl . urlencode($beer->brewery . ' ' . $beer->name);

        $scraper = $this->client->request('GET', $searchurl);

        $url = $scraper->filter('table tr:nth-child(2)')->each(function($tr) {
            $urls = $tr->filter('a')->each(function($a) {
                return $this->baseUrl . $a->attr('href');
            });
            if (empty($urls)) {
                return array();
            }

            return $urls[0];
        });

        if (!empty($url)) {
            $beer->ratebeerurl = $url[0];
        }
    }

    /**
     * Get a beer's overall rating from it's ratebeer URL.
     *
     * @param string $url
     *
     * @return array<int>
     */
    protected function getRatingFromUrl($url)
    {
        $crawler = $this->client->request('GET', $url);

        return $this->getRatingFromCrawler($crawler);
    }

    /**
     * Get a beer's overall rating from a crawler containing a Ratebeer beer page.
     *
     * @return array<int>
     */
    public function getRatingFromCrawler(Crawler $crawler)
    {
        return $crawler->filter('#_aggregateRating6 div[itemprop=ratingValue]')->each(function ($span) {
            return $span->text();
        });
    }
}
