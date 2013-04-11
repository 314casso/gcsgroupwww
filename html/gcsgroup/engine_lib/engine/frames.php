<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<head>
  <title>Панель управлеиня</title>
</head>

<script type="text/javascript">
  proc = parent.window.proc;
  move_to = parent.window.move_to;
</script>

<frameset cols="300,*" border="0" style="border-width: 0px; border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black">
  <frame scrolling="No" src="menu.php?session_time=<? echo $_GET[session_time];?>"  name="menu">
  <frame scrolling="Auto" noresize src="view.php?action=showdoc&id=-1&session_time=<? echo $_GET[session_time];?>" name="view" style="border-right: 1 solid #a0a0a0;border-left: 1 solid white; border-top: 1 solid white;">
</frameset>

<html>
  <body></body>
</html>

