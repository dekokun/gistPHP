<form method="POST" action="/repos/<?php echo $repo_id ?>">
  <input type="hidden" name="_METHOD" value="PUT">
  <fieldset>
    <legend>既存ファイルの編集</legend>
<?php foreach($files_info as $file_info): ?>
  <textarea name="<?php echo $file_info['name'] ?>"><?php echo $file_info['contents'] ?></textarea>
<?php endforeach; ?>
  </fieldset>
  <fieldset>
    <legend>ファイル追加</legend>
<textarea name="index_txt_<?php echo $next_file_count?>">
</textarea>
  </fieldset>
<input type="submit" value="Submit">
</form>
