<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '206781927169459',
        'client_secret' => '24783b2b65fcbe6133763a6dcd7aca26',
        'redirect' => 'http://to-find.herokuapp.com/login/facebook/callback',
    ],
    'google' => [
        'client_id' => '970225267324-8ro2l6b42gdg6m345ve988eeth4mhil7.apps.googleusercontent.com',
        'client_secret' => 'PcDvydW8G8dGB-xnrLNgqn5I',
        'redirect' => 'http://to-find.herokuapp.com/login/google/callback',
    ],
];
