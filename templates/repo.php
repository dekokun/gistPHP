<?php foreach($files as $file): ?>
<pre class="prettyprint"><?php echo $file ?></pre>
<?php endforeach; ?>
<form method="GET" action="/repos/<?php echo $repo_id ?>/edit">
  <input type="submit" value="編集">
</form>
<pre class="prettyprint">
<?php foreach($logs as $log): ?>
<?php echo $log ?>
<?php endforeach; ?>
</pre>
