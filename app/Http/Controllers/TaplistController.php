<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Listing;

use Illuminate\Http\Request;

class TaplistController extends Controller
{
    public function index()
    {
        $listings = Listing::where('is_available', 1)->get();

        return $this->render('taplist.index', ['listings' => $listings]);
    }
}
