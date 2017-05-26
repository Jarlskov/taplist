<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMikkellerAndFriendsCopenhagenBar extends Migration
{
    protected $name = 'Mikkeller And Friends Bar, Copenhagen';

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
            'scraperClass' => 'MikkellerAndFriendsBarCopenhagenScraper',
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
