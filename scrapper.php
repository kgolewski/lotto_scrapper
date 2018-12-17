<?php

require_once "vendor/autoload.php";

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(
    [
        'timeout'         => 0,
        'allow_redirects' => false
    ]
);

$response = $client->get('https://www.elgordo.com/results/euromillonariaen.asp');

if ($response->getStatusCode() == 200) {
    $crawler = new Crawler($response->getBody());

    $lottery = [
        'date' => '',
        'name' => '',
        'winners' => [],
        'winning_numbers' => [],
        ''
    ];
}
