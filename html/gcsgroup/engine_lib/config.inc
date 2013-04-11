<?
@session_start();
@session_register("engine_htroot");
@session_register("engine_root");
@session_register("engine_show_htroot");
@session_register("engine_show_root");

@session_register("db_host");
@session_register("db_user");
@session_register("db_pass");
@session_register("db_name");

$db_host="localhost";
$db_user="gcs_group";
$db_pass="gcS2007";
$db_name="gcsgroup";
$engine_root="c:/httpd/htdocs/gcsgroup/engine_lib";
$engine_htroot=$engine_show_htroot."/engine_lib";
if (!$engine_show_root)
	$engine_show_root=$dir;
if (!$engine_show_htroot)
	$engine_show_htroot=$htroot;

$wrong_path_404=0;

?>