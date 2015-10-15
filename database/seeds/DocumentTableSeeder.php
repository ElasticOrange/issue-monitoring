<?php

use Illuminate\Database\Seeder;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domain = \Issue\Domain::create([
            'parent_id' => 0,
        ]);

        $domainNames = [ 'ro' => 'Domenii', 'en' => 'Domains'];
        foreach (['ro', 'en'] as $locale) {
            $domain->translateOrNew($locale)->name = $domainNames[$locale];
        }

        $domain->save();

        foreach (range(1, 3) as $index) {
	        $domain = \Issue\Domain::create([
	            'parent_id' => 1,
	        ]);

	        $string = str_random(6);
	        $domainNames = [ 'ro' => $string.'_ro', 'en' => $string.'_en'];
	        foreach (['ro', 'en'] as $locale) {
	            $domain->translateOrNew($locale)->name = $domainNames[$locale];
	        }

	        $domain->save();
        }

        foreach (range(1, 7) as $index) {
	        $domain = \Issue\Domain::create([
	            'parent_id' => rand(2,4),
	        ]);

	        $string = str_random(6);
	        $domainNames = [ 'ro' => $string.'_ro', 'en' => $string.'_en'];
	        foreach (['ro', 'en'] as $locale) {
	            $domain->translateOrNew($locale)->name = $domainNames[$locale];
	        }

	        $domain->save();
        }
    }
}