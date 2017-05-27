<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Http\Requests\BeerRequest;
use App\Scraper\RatebeerScraper;
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
        $beer->save();

        return ['beer' => $beer];
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
