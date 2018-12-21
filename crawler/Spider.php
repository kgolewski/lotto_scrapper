<?php

namespace Crawler;

interface Spider {

    public function crawl();

    public function getResults();
}