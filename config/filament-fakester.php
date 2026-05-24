<?php

// config for Iammuttaqi/FilamentFakester
return [
    'enabled' => env('FAKESTER_ENABLED', ! app()->isProduction()),
];
