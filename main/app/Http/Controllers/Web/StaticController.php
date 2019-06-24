<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Cache;

class StaticController extends Controller
{
    public function langJs()
    {
        Cache::forget('lang.js');
        $strings = Cache::remember('lang.js', 3600, function () {
            $lang = config('app.locale');

            $files = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });
        $this->echoJS('translations', $strings);
    }

    private function echoJS(string $key, $javascript)
    {
        header('Content-Type: text/javascript');
        echo('window.' . $key . ' = ' . json_encode($javascript) . ';');
        exit();
    }
}