<?php

namespace App\Http\Controllers;

use App\Bar;
use App\Http\Requests;
use App\Listing;

use Illuminate\Http\Request;

class TaplistController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['bar', 'beer'])->where('is_available', 1)->get();
        $bars = Bar::all();

        return $this->render('taplist.index', [
            'bars' => $bars,
            'listings' => $listings
        ]);
    }
}
