<?php

return [
        
    'proxy_on' => false,
    'proxy_url' => ' https://app.scrapingbee.com/api/v1/?api_key='.env('SCRAPING_BEE_KEY').'&render_js=false&url=',
    'proxy_url_2' => 'pr.oxylabs.io',
    'proxy_port' => 7777,
    'proxy_user' => env('PROXY_USER'),
    'proxy_pass' => env('PROXY_PASS')
];
