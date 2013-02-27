{% extends "layout.php" %}
{% block content %}
<form method="POST" action="/repos/{{repo_id}}">
  <input type="hidden" name="_METHOD" value="PUT">
  <fieldset>
    <legend>編集</legend>
    <textarea id="code" name="contents">{{file}}</textarea>
    <div class="control-group">
      <label for="description">変更内容</label>
      <div class="controls">
        <div class="input-prepend">
          <span class="add-on"><i class="icon-pencil"></i></span>
          <input id="description" type="text" name="comment">
        </div>
      </div>
    </div>
  </fieldset>
  <input class="btn" type="submit" value="Submit">
</form>
{% endblock %}
