<textarea><?php echo h($file) ?></textarea>
<form method="GET" action="/repos/<?php echo $repo_id ?>/edit">
  <input type="submit" value="編集">
</form>
<textarea class="prettyprint">
<?php foreach($logs as $log): ?>
<?php echo $log ?>
<?php endforeach; ?>
</textarea>
