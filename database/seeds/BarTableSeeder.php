<?php

use Illuminate\Database\Seeder;

class BarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bars = array(
            array(
                'name' => 'Taphouse',
                'scraperclass' => 'TaphouseScraper',
            ),
            array(
                'name' => 'Warpigs',
                'scraperclass' => 'WarpigsScraper',
            ),
            array(
                'name' => 'Fermentoren',
                'scraperclass' => 'FermentorenScraper',
            ),
            array(
                'name' => 'Banksia Food & Beer',
                'scraperclass' => 'BanksiaScraper',
            ),
        );

        foreach ($bars as $bar) {
            DB::table('bars')->insert(array(
                'name' => $bar['name'],
                'scraperclass' => $bar['scraperclass'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
        }
    }
}
