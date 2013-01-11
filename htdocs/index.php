<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
use TQ\Git\Cli\Binary;
use TQ\Git\Repository\Repository;

define('APP_DIR', dirname(__FILE__) . '/../');
define('REPO_DIR', APP_DIR . 'repos/');
define('TEMPLATE_DIR', APP_DIR . 'templates/');

$app = new Slim(array(
  'view' => new View(),
  'templates.path' => TEMPLATE_DIR
));

View::set_layout('layout.php');

$binary = new Binary('/usr/bin/env git');

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
  $in_repo_files = glob("$repo_dir/*");
  if (count($in_repo_files) > 0) {
    foreach ($in_repo_files as $file) {
      $base_name = basename($file);
      echo '<form method="POST" action="/repos/' . $repo_id . '">';
      echo '<textarea name="' . $base_name . '">';
      echo htmlspecialchars($git->showFile($base_name, 'HEAD'));
      echo '</textarea>';
      echo '<input type="hidden" name="_METHOD" value="PUT">';
      echo '<input type="submit" value="Submit">';
      echo '</form>';
    }
  } else {
    echo '<form method="POST" action="/repos/' . $repo_id . '">';
    echo '<textarea name="index_txt">';
    echo '</textarea>';
    echo '<input type="hidden" name="_METHOD" value="PUT">';
    echo '<input type="submit" value="Submit">';
    echo '</form>';

  }

});

$app->put('/repos/:repo_id', function ($repo_id) use ($app, $binary) {
  $repo_dir = REPO_DIR . $repo_id;
  $git = Repository::open($repo_dir, $binary, 0755);
  $post_vars = $app->request()->post();
  foreach ($post_vars as $key => $value) {
    if ($key !== '_METHOD') {
      $file_name = $key;
      file_put_contents("$repo_dir/$file_name", $value);
      $git->add(array($file_name));
    }
  }
  if ($git->isDirty()) {
    $git->commit(date('Y/m/d H:i:s'));
  }
  $app->redirect("/repos/$repo_id/HEAD");
});

$app->get('/repos/:repo_id/:commit_id', function ($repo_id, $commit_id) use ($app, $binary) {
  $repo_dir = REPO_DIR . $repo_id;
  if (!file_exists($repo_dir)) {
    $app->redirect('/404');
  }
  $git = Repository::open($repo_dir, $binary, 0755);
  $in_repo_files = glob("$repo_dir/*");
  $files = array();
  foreach ($in_repo_files as $file) {
    $base_name = basename($file);
    $files[] = $git->showFile($base_name, $commit_id);
  }
  $app->render('repo.php',
    array(
      'files'=>$files,
      'repo_id'=>$repo_id,
      'logs'=>$git->getLog()
    ));
});

$app->post('/repos', function () use ($app, $binary) {
  $repo_id = 1;
  while (!@mkdir($repo_dir = REPO_DIR . $repo_id)) {
    $repo_id += 1;
  }
  $binary->init($repo_dir);
  $app->redirect("/repos/$repo_id/edit");
});

$app->notFound(function () use ($app) {
  $app->render('404.php');
});

$app->run();
