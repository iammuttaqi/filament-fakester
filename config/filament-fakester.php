<?php

// config for Iammuttaqi/FilamentFakester
return [
    'enabled' => env('FAKESTER_ENABLED', ! app()->isProduction()),

    'features' => [
        'hint_action' => true,
        'fill_form_action' => true,
        'fake_row_action' => true,
        'bulk_fake_action' => true,
        'seed_resource' => true,
    ],

    'default_count' => 25,
];
