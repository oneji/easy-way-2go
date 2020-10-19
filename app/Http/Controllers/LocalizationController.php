<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class LocalizationController extends Controller
{
    /**
     * Switch application's language
     * 
     * @param string $lang
     */
    public function switchLanguage($lang)
    {
        App::setLocale($lang);
        \LaravelLocalization::setLocale($lang);

        $url = \LaravelLocalization::getLocalizedURL(App::getLocale(), \URL::previous());
        return Redirect::to($url);
    }
}
