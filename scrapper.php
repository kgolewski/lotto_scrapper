<?php

require_once "vendor/autoload.php";

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


function crawlElgordo($httpClient) {
    $response = $httpClient->get('https://www.elgordo.com/results/euromillonariaen.asp');
    $statusCode = $response->getStatusCode();

    if ($statusCode != 200) {
        error_log("Unexpected HTTP status code:");
        return;
    }

    $crawler = new Crawler($response->getBody()->getContents());

    $balls = $crawler->filter('.balls .num')->each(function (Crawler $node, $i) {
        return (int)$node->text();
    });

    $stars = $crawler->filter('.esp .int-num')->each(function (Crawler $node, $i) {
        return (int)$node->text();
    });

    $winners = [];

    $crawler->filter('.tbl-result tbody tr')->each(function (Crawler $node, $i) use (&$winners) {
        $cells = $node->filter('td')->each(function (Crawler $childNode, $j) {
            return $childNode->text();
        });

        $columnCount = count($cells);
        if ($columnCount !== 3) {
            error_log("Unexpected column count: $columnCount");
            return;
        }

        $winners[$cells[0]] = [
            "winner_count" => parseInt($cells[1]),
            "prizes_in_cents" => parseInt($cells[2]),
        ];
    });

    print_r($crawler->filter('td[data-title="Collection:"]'));
    $collection = parseInt(
        $crawler->filter('td[data-title="Collection:"]')->first()->text()
    );
    $jackpot = parseInt(
        $crawler->filter('td[data-title="Jackpot for this draw:"]')->first()->text()
    );

    return [
        "balls" => $balls,
        "stars" => $stars,
        "winners" => $winners,
        "collection" => $collection,
        "jackpot" => $jackpot,
    ];
}


function parseInt(string $string) {
    return (int) preg_replace('/\D+/', '', $string);
}

$httpClient = new Client(
    [
        'timeout'         => 0,
        'allow_redirects' => false
    ]
);

var_dump(crawlElgordo($httpClient));