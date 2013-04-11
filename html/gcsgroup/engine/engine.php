<?

$engine_show_root=preg_replace("|/engine/[^/]*$|i","",($DOCUMENT_ROOT.$PHP_SELF));

$engine_show_htroot=preg_replace("|/engine/[^/]*$|i","",($PHP_SELF));

include "config.inc";

$dir=$engine_show_root;

include "./../".$engine_htroot."/engine/engine.php";

?>
<!--
<body scroll=no

topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>

<iframe frameborder=no id=efrm width=100% height=100% src='<?=$engine_htroot?>/engine/engine.php?dir=<?=$engine_show_root?>&htroot=<?=$engine_show_htroot?>'>

</iframe >

</body>
-->
