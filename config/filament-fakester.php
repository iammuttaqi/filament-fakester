<?php

// config for Iammuttaqi/FilamentFakester
return [
    'enabled' => env('FAKESTER_ENABLED', env('APP_ENV') !== 'production'),

    'features' => [
        'hint_action' => true,
        'fake_row_action' => true,
        'bulk_fake_action' => true,
    ],

    'default_count' => 25,
];
