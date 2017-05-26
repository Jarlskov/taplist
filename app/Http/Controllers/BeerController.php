<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Scraper\RatebeerScraper;
use Illuminate\Http\Request;

class BeerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('beer.index', ['beer' => Beer::all()->keyBy('id')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BeerRequest $request, Beer $beer)
    {
    }

    /**
     * Update a beer's rating from Ratebeer.
     */
    public function reloadRateBeerRating(Beer $beer, RatebeerScraper $scraper)
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
