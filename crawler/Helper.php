<?php

namespace Crawler;

class Helper {

    public static function listSpiders() {
        $allSpiders = self::getAllSpiders();

        foreach ($allSpiders as $spiderName => $class) {
            echo $spiderName . PHP_EOL;
        }
    }

    public static function crawlAll() {
        $allSpiders = self::getAllSpiders();

        $result = [];

        foreach ($allSpiders as $className) {
            $spider = new $className();

            $spider->crawl();

            $result[] = $spider->getResults();
        }

        return $result;
    }

    public static function saveResults($filename, $results) {
        if (!is_writable($filename)) {
            throw new \Exception('Cannot save output file');
        }

        file_put_contents($filename, json_encode($results));
    }

    public static function enocodeResults($results) {
        return json_encode($results);
    }

    private static function getAllSpiders() {
        return [
            'elgordo' => 'Crawler\\Spiders\\Elgrodo',
            'lotto' => 'Crawler\\Spiders\\Lotto',
            'eurojackpot' => 'Crawler\\Spiders\\EuroJackpot'
        ];
    }
}
