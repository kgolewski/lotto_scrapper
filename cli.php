<?php

require 'vendor/autoload.php';


use GetOptionKit\OptionCollection;
use GetOptionKit\OptionParser;
use Crawler\Helper;

$options = new OptionCollection();

$options->add('o|output?', 'Filename to save json results in')
        ->isa('string');
$options->add('list', 'List available spiders')
        ->isa('boolean');
$options->add('crawl', 'Crawl all sites')
        ->isa('boolean');


$optionParser = new OptionParser($options);

$arguments = $optionParser->parse( $argv );

if (isset($arguments['list'])) {
    Helper::listSpiders();
} elseif (isset($arguments['crawl'])) {

    $crawled = Helper::crawlAll();

    if (!isset($arguments['output'])) {
        echo Helper::enocodeResults($crawled) . PHP_EOL;
    } else {
        $output = $arguments['output']->getValue();
var_dump($output);
        Helper::saveResults($output, $crawled);
    }
}

