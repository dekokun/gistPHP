<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
use TQ\Git\Cli\Binary;
use TQ\Git\Repository\Repository;

define('APP_DIR', dirname(__FILE__) . '/../');
define('REPO_DIR', APP_DIR . 'repos/');

$app = new Slim(array(
));

$app->view(new View());
$binary = new Binary('/usr/bin/env git');

$app->get('/', function () {
    echo 'hoge';
});

$app->get('/repos/:repo_id', function ($repo_id) use($app) {
    $app->redirect("/repos/$repo_id/HEAD");
});

$app->get('/repos/:repo_id/:commit_id', function ($repo_id, $commit_id) use($app, $binary) {
    $repo_dir = REPO_DIR . $repo_id;
    if (! file_exists($repo_dir)) {
        $app->redirect('/404');
    }
    $git = Repository::open($repo_dir, $binary, 0755);
    echo '<pre>';
    var_dump($git->getCurrentBranch());
    var_dump($git->getCurrentCommit());
    var_dump($git->getStatus());
    var_dump($git->getLog());
    var_dump($git->showFile('index.txt', $commit_id));
    echo $repo_id;
    echo '</pre>';
    echo '<A HREF="" onclick="document.form1.submit();return false;" > 作成</A>
<form name="form1" method="POST" action="/repos">
</form>';
});

$app->post('/repos', function() use($app) {
    $repo_id = 1;
    while(! @mkdir($repo_dir = REPO_DIR . $repo_id)) {
        $repo_id += 1;
    }
    $app->redirect("/repos/$repo_id/HEAD");
});

$app->notFound(function () use ($app) {
    echo '<html><body><h1>ページが見つかりません</h1></body></html>';
});

$app->run();
