<?php

require_once dirname(__FILE__) . '/../lib/Autoload.php';

$app = new Slim();

$app->get('/', function () {
    echo 'hoge';
});

$app->notFound(function () use ($app) {
    echo '<html><body><h1>ページが見つかりません</h1></body></html>';
});

$app->run();
