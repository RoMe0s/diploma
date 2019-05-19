<?php

use App\Constants\Plan\Key;
use App\Constants\Plan\SettingBlock;
use App\Constants\Plan\Heading;

return [
    'heading' => [
        Heading::H2 => 'H2',
        Heading::H3 => 'H3',
        Heading::H4 => 'H4',
        Heading::H5 => 'H5',
        Heading::H6 => 'H6'
    ],
    'setting-block' => [
        SettingBlock::BOLD => 'bold',
        SettingBlock::ITALIC => 'italic',
        SettingBlock::IMAGE => 'image',
        SettingBlock::VIDEO => 'video'
    ],
    'key' => [
        Key::STRICT => 'strict',
        Key::NOT_STRICT => 'not strict'
    ]
];
