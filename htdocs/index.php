<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';


$app = new Slim(array(
));

$my_view = new View();

$app->get('/', function () {
    echo 'hoge';
});

$app->notFound(function () use ($app) {
    echo '<html><body><h1>ページが見つかりません</h1></body></html>';
});

$app->run();
