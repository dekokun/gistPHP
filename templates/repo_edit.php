<form method="POST" action="/repos/<?php echo $repo_id ?>">
  <input type="hidden" name="_METHOD" value="PUT">
    <fieldset>
      <legend>編集</legend>
        <textarea id="code" name="contents"><?php echo (array_key_exists('contents', $file_info) ? h($file_info['contents']) : '') ?></textarea>
        変更内容：<input type="text" name="comment">
    </fieldset>
  <input type="submit" value="Submit">
</form>
