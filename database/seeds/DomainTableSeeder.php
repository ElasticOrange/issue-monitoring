<?php

use Illuminate\Database\Seeder;

class DomainTableSeeder extends Seeder
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
    }
}
