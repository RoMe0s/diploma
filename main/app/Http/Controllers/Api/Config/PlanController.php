<?php

namespace App\Http\Controllers\Api\Config;

use App\Constants\Plan\Heading;
use App\Constants\Plan\SettingBlock;
use App\Constants\Plan\Key;
use App\Http\Controllers\Api\Controller;

class PlanController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'headings' => Heading::getConfig(),
            'settings' => SettingBlock::getConfig(),
            'keys' => Key::getConfig()
        ]);
    }
}
