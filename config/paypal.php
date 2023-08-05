<?php

return [
    'client_id' => 'AaTSPrZl4ADfOzQdBCcj7z9tyN0c-MAKvpc2f06_HEZtn-8V09B3E0dZqUnr8yjXkZRw8i3SZV94s7Nj',
    'secret' => 'EM5ljaUCee-B4i8j2w0JJKwn94mSzBTTe8Jupfg-xfzLJOa0kEe5vycP1x8TfIGiza7dWcGJUDE-t5iS',
    'settings' => [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ]
];
