<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class StaticController extends Controller
{
    public function langJs()
    {
        $strings = Cache::remember('lang.js', 1, function () {
            $lang = config('app.locale');

            $files = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.translations = ' . json_encode($strings) . ';');
        exit();
    }
}