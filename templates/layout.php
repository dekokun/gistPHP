<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo isset($title) ? $title . ' - '  : ''?>gistphp</title>
  <link href="http://google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" type="text/css" rel="stylesheet"></link>
</head>
<body>
<?php echo $_html ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<!-- Code syntax highlight -->
<script type="text/javascript " src="http://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<script type="text/javascript">
  $(function(){
    $('pre').css({
      'overflow-x': 'scroll',
      'background-color': '#f6f6f6',
      'border': '1px dotted #ccc',
      'padding': '0.8em'
    });
    prettyPrint();
  });
</script>
</body>
</html>