<?php

return [
    'base_ap_url' => rtrim(env('BASE_API_URL'), '/'),
    'cache_duration' => env('CACHE_DURATION', 5000),
    'rate_limit' => env('RATE_LIMIT', 20),
    'max_attempt' => env('MAX_ATTEMPT', 1),
];
