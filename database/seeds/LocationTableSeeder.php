<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = \Issue\Location::create([
            'parent_id' => 0,
        ]);

        $locationNames = [ 'ro' => 'Locatii', 'en' => 'Locations'];
        foreach (['ro', 'en'] as $locale) {
            $location->translateOrNew($locale)->name = $locationNames[$locale];
        }

        $location->save();
    }
}
