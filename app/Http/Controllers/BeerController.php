<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Http\Requests\BeerRequest;
use App\Scraper\RatebeerScraper;
use App\Services\UntappdService;
use Illuminate\Http\Request;

class BeerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return ['beer' => Beer::all()->keyBy('id')];
        }

        return view('beer.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BeerRequest $request, Beer $beer)
    {
        $beer->name = $request->get('name');
        $beer->brewery = $request->get('brewery');
        $beer->ratebeerurl = $request->get('ratebeerurl');
        $beer->untappd_id = $request->get('untappd_id');
        $beer->save();

        return ['beer' => $beer];
    }

    /**
     * Update a beer's rating from Ratebeer.
     */
    public function reloadRatebeerRating(Beer $beer, RatebeerScraper $scraper)
    {
        $rating = $scraper->getRatingForBeer($beer);
        if (empty($rating)) {
            return;
        }

        $beer->ratebeeroverallrating = $rating[0];
        $beer->save();

        return ['rating' => $beer->ratebeeroverallrating];
    }

    /**
     * Update a beer's rating from Untappd.
     */
    public function reloadUntappdRating(Beer $beer, UntappdService $service)
    {
        $beer->untappd_rating = $service->beerInfo($beer->untappd_id)->response->beer->rating_score;
        $beer->save();

        return ['rating' => $beer->untappd_rating];
    }

    public function getUntappdMatches(Beer $beer, UntappdService $service)
    {
        return $service->beerSearch($beer->brewery . ' ' . $beer->name)->response->beers->items;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
