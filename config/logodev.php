<?php

// config for Syntaxsapiens/LogoDev
return [
    'publishable_key' => env('LOGODEV_PUBLISHABLE_KEY'),
    'secret_key' => env('LOGODEV_SECRET_KEY'),
    'size' => null,     // Default: 128
    'format' => null,   // Default: jpg
    'greyscale' => null, // Default: false
    'fallback' => null, // Default: Monogram
];
