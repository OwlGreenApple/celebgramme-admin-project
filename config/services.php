<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => 'Yu-hGwfENEg6gu_w0Pc8XA',
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model'  => Celebgramme\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
		
		'google' => [
      'client_id' => env('GOOGLE_KEY'),
			'client_secret' => env('GOOGLE_SECRET'),
			'redirect' => env('GOOGLE_REDIRECT'),
    ],
		
		'facebook' => [
      'client_id' => env('FACEBOOK_KEY'),
			'client_secret' => env('FACEBOOK_SECRET'),
			'redirect' => env('FACEBOOK_REDIRECT'),
    ],
];
