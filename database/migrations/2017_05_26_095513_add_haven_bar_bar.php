<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHavenBarBar extends Migration
{
    protected $name = 'Haven Bar';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Bar::unguard();

        $bar = \App\Bar::create([
            'name' => $this->name,
            'scraperClass' => 'HavenBarScraper',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Bar::where('name', $this->name)->delete();
    }
}
