{% extends "layout.php" %}
{% block content %}
<textarea id="code">{{file}}</textarea>
<form method="GET" action="/repos/{{repo_id}}/edit">
  <input class="btn" type="submit" value="編集">
</form>
{% for commit in history %}
  <div>
    <p><a href="/repos/{{repo_id ~ '/' ~ commit.hash}}">{{commit.hash|slice(1,6)}}</a>{{commit.message}}</p>
  </div>
{% endfor %}
{% endblock %}
