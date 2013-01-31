<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo isset($title) ? $title . ' - ' : ''?>gistphp</title>
  <link href="/twitter_bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet"></link>
  <link href="/codemirror/codemirror.css" type="text/css" rel="stylesheet"></link>
  <link href="/css/application.css" type="text/css" rel="stylesheet"></link>
</head>
<body>
<div class="container">
  <div class="navbar">
    <div class="nav-inner">
      <a class="brand" href="#">gistPHP</a>
      <ul class="nav">
        <li>
          <a href="/">Home</a>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
<?php echo $_html ?>
</div>
<script type="text/javascript " src="/codemirror/codemirror-compressed.js"></script>
<script>
  var code = document.getElementById("code");
  var conf = {
    <?php echo (isset($mode) ? "mode: " . $mode . ',': '') ?>
    <?php echo ((isset($readonly) && $readonly) ? "readOnly: 'nocursor'" . ',': '') ?>
    lineNumbers: true,
    showCursorWhenSelecting: true,
    smartIndent: false,
  };
  CodeMirror.fromTextArea(code, conf);

</script>
<script src="/twitter_bootstrap/js/bootstrap.min.js"></script>
</body>
</html>