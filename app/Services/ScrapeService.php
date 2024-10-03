<?php

namespace App\Services;

class ScrapeService
{
    public static function getXpath($sourceUrl)
    {

        $userAgents = config('userAgents');
        $userAgent = $userAgents[array_rand($userAgents)];

        $headers = array(
            'User-Agent: ' . $userAgent,
        );

        $ctx = stream_context_create(array('http' => array_merge(array('timeout' => 10), $headers)));
        $html = file_get_contents($sourceUrl, false, $ctx);

        if (empty($html)) {
            return null;
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html, LIBXML_NOWARNING);
        $xpath = new \DOMXpath($doc);

        $nodes = $doc->getElementsByTagName('*');

        if ($nodes->length > 0) {
            return $xpath;
        } else {
            return null;
        }
    }

    public static function getCurl($sourceUrl)
    {

        try {
            $userAgents = config('userAgents');
            $userAgent = $userAgents[array_rand($userAgents)];

            $headers = array(
                'User-Agent: ' . $userAgent,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sourceUrl);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_status == 403)
                dd('Received 403 Forbidden for URL: ' . $sourceUrl);

            if ($output === false || empty($output)) {
                dd('Failed to fetch or Empty HTML for URL: ' . $sourceUrl);
            } else {
                return $output;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public static function getScrapingBee($sourceUrl) {
        try {
            $userAgents = config('userAgents');
            $userAgent = $userAgents[array_rand($userAgents)];

            $headers = array(
                'User-Agent: ' . $userAgent,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://app.scrapingbee.com/api/v1/?api_key='.env("SCRAPINGBEE").'&render_js=false&url='.urlencode($sourceUrl));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $output = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_status == 403)
                dd('Received 403 Forbidden for URL: ' . $sourceUrl);

            if ($output === false || empty($output)) {
                dd('Failed to fetch or Empty HTML for URL: ' . $sourceUrl);
            } else {
                return $output;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    
    }
}
