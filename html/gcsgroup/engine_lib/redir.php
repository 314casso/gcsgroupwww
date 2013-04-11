<?
$url="http://".$SERVER_NAME.$REQUEST_URI;
if (isset($_deb)) {
    echo "debug: $_deb";
    exit;
}
include "engine/config.inc";
include_once "engine_lib/engine/functions.php";
//if (file_exists($engine_show_root.$REQUEST_URI) ){
//        include $engine_show_root.$REQUEST_URI;
//}
//else {
        $db = mysql_connect($db_host, $db_user,$db_pass)
                        or die("Unable to connect to sql server\n");
        mysql_select_db($db_name, $db) or die("Unable to select database\n");

    if ($error404 == 1) {
        $r = db_select("select varvalue as id from engine_conf c where c.varname='doc404'");
        if (db_get_rows_affected() == 0) {
            header("HTTP/1.0 404 Not Found");
            echo "Документ <br><b>$url</b><br> не найден! Код $doc";
            exit;
        }
        $r_ = db_get_array($r);
        include_once "engine_lib/engine/config.inc";
        include_once "engine_lib/engine/document.inc";
        $doc = new Document ($r_['id'],0);
        header("HTTP/1.0 301 Moved");
        header("Location: ".$doc->geturl());
        exit;
    } else {

        preg_match("|(.*/)(.*)\.html|",str_replace($QUERY_STRING,"",$REQUEST_URI),$res);
        $doc=$res[2];
        preg_match("@/(srch_cntnt|".ENGINE_CONTENT_PREFIX."|srch)(.*)/@Usi",$res[1],$res);
        if ($res[1]=='srch_cntnt')
                $msrch=1;

        if ($res[1]=='srch' and $doc=='result'){
                $doc="";
                if (!$search)$search="---";
                }
        else  if ($search){
                header ("Location: /srch/result.html?search=".urlencode($search));
                exit;
                }

      if (is_array($dbview))
      foreach ($dbview as $dir => $tbl){
              if ($res[1]==$dir){
                         $table=$tbl;
                         $sku=$doc;
                         $doc="";
                      }
              }

//     if (preg_match("|/shop/((.*/)?(.*)\.html.*)$|Usi",$REQUEST_URI,$res)){
    if (preg_match("@(shop_redirect|srch_shop|shop)/(.*)$@Usi",$REQUEST_URI,$res)) {
                if ($res[1]=='srch_shop') {
                        $msrch=1;
                        $doc=$cmscarddoccode;
                        $icurl="http://$ichost/cgi-bin/$iccat.cgi/".$res[2];
                } else if ($res[1]=='shop_redirect') {
                        preg_match("@([^/]*)/(.*)$@Usi",$res[2],$res);
                        $icurl="http://$ichost/cgi-bin/$iccat.cgi/".$res[2];
                        $doc=$res[1];
                global $forprint;
                $icpage=geticpage($icurl, 1, 0, ($forprint == 1), true);
            } else if($res[1]=='shop') {
                if (!$showdoc and !$showurl) {
                                $doc=$cmscarddoccode;
                                $icurl="http://$ichost/cgi-bin/$iccat.cgi/".$res[2];
                        } else {
                                $icurl="http://$ichost/cgi-bin/$iccat.cgi/".$res[2];
                                $icpage=geticpage($icurl, 1);
                                if ($showdoc)
                                        $doc=$showdoc;
                                else {
                                        header("Location: ".$showurl);
                                        exit;
                                }
                        }
                }
        }



        preg_match("|/icproducts.*/(.*)\.html|Usi",str_replace($QUERY_STRING,"",$REQUEST_URI),$res);
    if ($iccard=$res[1]) $doc="";
    if (!$sku and !$iccard) {
        $sql="select * from engine_documents where code='$doc' or id='$doc'";
        $r=mysql_query("$sql");
        if (!mysql_num_rows($r)) {
            $r = db_select("select varvalue as id from engine_conf c where c.varname='doc404'");
            if (db_get_rows_affected() == 0) {
                header("HTTP/1.0 404 Not Found");
                echo "Документ <br><b>$url</b><br> не найден! Код $doc";
                exit;
            }
            $r_ = db_get_array($r);
            include_once "engine_lib/engine/config.inc";
            include_once "engine_lib/engine/document.inc";
            $doc = new Document ($r_['id'],0);
            header("HTTP/1.0 301 Moved");
            header("Location: ".$doc->geturl());
            exit;
        } else {
            include "show.php";
        }
    } else {
        include "show.php";
    }
    }

//}
?>
