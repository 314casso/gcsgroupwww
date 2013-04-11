<?

include "engine/config.inc";

$engine_show_root=preg_replace("|/[^/]*$|i","",($DOCUMENT_ROOT.$PHP_SELF));

$engine_show_htroot=preg_replace("|/[^/]*$|i","",($PHP_SELF));

include "$engine_root/show.php";



?>