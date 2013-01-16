<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
use TQ\Git\Cli\Binary;
use TQ\Git\Repository\Repository;

define('APP_DIR', dirname(__FILE__) . '/../');
define('REPO_DIR', APP_DIR . 'repos/');
define('TEMPLATE_DIR', APP_DIR . 'templates/');

function h($str, $encoding='UTF-8') {
  return htmlspecialchars($str, ENT_QUOTES, $encoding);
}

$app = new Slim(array(
  'view' => new View(),
  'templates.path' => TEMPLATE_DIR
));

View::set_layout('layout.php');

$binary = new Binary('/usr/bin/env git');
$bookshelf = new BookShelf(REPO_DIR, 'TQ\Git\Repository\Repository', $binary);

$app->get('/', function () use ($app) {
  $app->render('index.php');
});

$app->get('/repos/:repo_id', function ($repo_id) use ($app) {
  $app->redirect("/repos/$repo_id/HEAD");
});

$app->get('/repos/:repo_id/edit', function ($repo_id) use ($app, $binary) {
  $repo_dir = REPO_DIR . $repo_id;
  $git = Repository::open($repo_dir, $binary, 0755);
  if (!file_exists($repo_dir)) {
    $app->redirect('/404');
  }
  $in_repo_files = glob($repo_dir . '/*');
  $file_info = array();
  if(count($in_repo_files) !== 0) {
    $file = $in_repo_files[0];
    $base_name = basename($file);
    $file_info = array();
    $file_info['name'] = $base_name;
    $file_info['contents'] = $git->showFile($base_name, 'HEAD');
  }
  $app->render('repo_edit.php',
    array(
      'repo_id'=>$repo_id,
      'file_info'=>$file_info
    )
  );
});

$app->put('/repos/:repo_id', function ($repo_id) use ($app, $binary) {
  $repo_dir = REPO_DIR . $repo_id;
  $git = Repository::open($repo_dir, $binary, 0755);
  $post_vars = $app->request()->post();
  foreach ($post_vars as $key => $value) {
    if ($key === 'contents') {
      $file_name = "$repo_dir/index_txt";
      file_put_contents($file_name, $value);
      $git->add(array($file_name));
    }
  }
  if ($git->isDirty()) {
    $git->commit(date('Y/m/d H:i:s') . ' ' .$post_vars['comment']);
  }
  $app->redirect("/repos/$repo_id/HEAD");
});

$app->get('/repos/:repo_id/:commit_id', function ($repo_id, $commit_id) use ($app, $bookshelf) {
  try {
    $book = $bookshelf->findBook($repo_id, $commit_id);
  } catch(InvalidArgumentException $e) {
    $app->redirect('/404');
  }
  try {
    $page = $book->getPage($commit_id);
  } catch(InvalidArgumentException $e) {
    $app->redirect('/404');
  }
  $app->render('repo.php',
    array(
      'file'=>$page,
      'repo_id'=>$repo_id,
      'history'=>$book->getHistory(),
      'readonly'=>true
    ));
});

$app->post('/repos', function () use ($app, $bookshelf) {
  $book_id = $bookshelf->makeBook();
  $app->redirect("/repos/$book_id/edit");
});

$app->notFound(function () use ($app) {
  $app->render('404.php');
});

$app->run();
