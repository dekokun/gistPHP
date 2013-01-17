<textarea id="code"><?php echo h($file) ?></textarea>
<form method="GET" action="/repos/<?php echo $repo_id ?>/edit">
  <input type="submit" value="編集">
</form>
<?php foreach($history as $commit): ?>
<div>
  <p><a href="/repos/<?php echo $repo_id . '/' . $commit->hash() ?>"><?php echo $commit->shorthash() ?></a><?php echo h($commit->message()) ?></p>
</div>
<?php endforeach; ?>
