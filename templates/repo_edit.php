<form method="POST" action="/repos/<?php echo $repo_id ?>">
  <input type="hidden" name="_METHOD" value="PUT">
<?php if(count($files_info) > 0): ?>
    <fieldset>
      <legend>既存ファイルの編集</legend>
<?php foreach($files_info as $file_info): ?>
      <fieldset>
        <legend><?php echo $file_info['name'] ?></legend>
        <textarea id="code" name="<?php echo $file_info['name'] ?>"><?php echo h($file_info['contents']) ?></textarea>
      </fieldset>
<?php endforeach; ?>
    </fieldset>
<?php endif; ?>
    <fieldset>
      <legend>ファイル追加</legend>
      <textarea name="new"></textarea>
    </fieldset>
  <input type="submit" value="Submit">
</form>
