<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo isset($title) ? $title . ' - ' : ''?>gistphp</title>
  <link href="/twitter_bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet"></link>
  <link href="http://codemirror.net/lib/codemirror.css" type="text/css" rel="stylesheet"></link>
  <link href="/codemirror/codemirror.css" type="text/css" rel="stylesheet"></link>
</head>
<body>
<?php echo $_html ?>
<script type="text/javascript " src="/codemirror/codemirror-compressed.js"></script>
<script>
  var code = document.getElementById("code");
  var conf = {
    <?php echo (isset($mode) ? "mode: " . $mode . ',': '') ?>
    <?php echo ((isset($readonly) && $readonly) ? "readOnly: true" . ',': '') ?>
    lineNumbers: true,
    showCursorWhenSelecting: true,
    smartIndent: false,
  };
  CodeMirror.fromTextArea(code, conf);

</script>
</body>
</html>