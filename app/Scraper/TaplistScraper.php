<?php

namespace App\Scraper;

use App\Bar;
use App\Scraper;
use App\Scraper\RatebeerScraper;

use DB;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

abstract class TaplistScraper
{
    /**
     * The bar we're scraping for.
     *
     * @var Bar
     */
    protected $bar;

    /**
     * The website scraper client.
     *
     * @var Client
     */
    protected $client;

    /**
     * The scraper class for scraping for Ratebeer data.
     *
     * @var RatebeerScraper
     */
    protected $ratebeerScraper;

    /**
     * Setup class defaults.
     */
    public function __construct(Bar $bar, RatebeerScraper $ratebeerScraper)
    {
        $this->bar = $bar;
        $this->ratebeerScraper = $ratebeerScraper;
        $this->client = new Client();
    }

    /**
     * Scrape the website for tap data.
     */
    public function scrape()
    {
        DB::table('listings')->where('bar_id', $this->bar->id)->where('is_available', 1)->update(['is_available' => 0]);

        $crawler = $this->client->request('GET', $this->url);

        $this->scrapeListingData($crawler);
    }

    /**
     * Scrape the page for tap listing data.
     *
     * @param Crawler $crawler
     */
    public abstract function scrapeListingData(Crawler $crawler);
}
