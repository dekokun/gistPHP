<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo isset($title) ? $title . ' - '  : ''?>gistphp</title>
  <link href="http://codemirror.net/lib/codemirror.css" type="text/css" rel="stylesheet"></link>
  <link href="/codemirror/codemirror.css" type="text/css" rel="stylesheet"></link>
</head>
<body>
<?php echo $_html ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript " src="/codemirror/codemirror-compressed.js"></script>
<script>
  var textareas = document.getElementsByTagName("textarea");
  var conf = {
    <?php echo (isset($mode) ? "mode: " . $mode . ',': '') ?>
    <?php echo ((isset($readonly) && $readonly) ? "readOnly: true" . ',': '') ?>
    lineNumbers: true,
    showCursorWhenSelecting: true,
    smartIndent: false,
  };
  var max = textareas.length;
  for(var i = 0; i < max; i++) {
    var newtextareas = jQuery.extend(true, {}, textareas);;
    CodeMirror.fromTextArea(newtextareas[i * 2], conf);
  }

</script>
</body>
</html>