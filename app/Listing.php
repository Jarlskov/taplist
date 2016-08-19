<?php

namespace App;

use App\Bar;
use App\Beer;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    /**
     * List of properties that can't be set in mass assignment.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * A listing is in a bar.
     */
    public function bar()
    {
        return $this->belongsTo(Bar::class);
    }

    /**
     * A listing lists a beer.
     */
    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }
}
