<form method="POST" action="/repos/<?php echo $repo_id ?>">
<?php foreach($files_info as $file_info): ?>
  <textarea name="<?php echo $file_info['name'] ?>"><?php echo $file_info['contents'] ?></textarea>
<?php endforeach; ?>
ファイル追加
<textarea name="index_txt_<?php echo $next_file_count?>">
</textarea>
<input type="hidden" name="_METHOD" value="PUT">
<input type="submit" value="Submit">
</form>
