<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = [
            [ 'name' => [ 'ru' => 'Русский', 'en' => 'Russian' ], 'code' => 'ru' ],
            [ 'name' => [ 'ru' => 'Английский', 'en' => 'English' ], 'code' => 'en' ]
        ];

        foreach($langs as $lang) {
            Language::create($lang);
        }
    }
}
