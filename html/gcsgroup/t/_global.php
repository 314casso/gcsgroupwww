<?
#####################################################################################################################################
## Project settings
#####################################################################################################################################
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);
    ini_set('max_execution_time', 9000);

    define('AppDBHost', 'localhost');
    define('AppDBName', 'hotels');
    define('AppDBUser', 'hotels');
    define('AppDBPwd',  '');
    define('AppName', "rp2");
    define('AppUrl', "http://".$_SERVER['SERVER_NAME']);
    
    $pg_types = array(1 => array("Текстовый",""), 2 => array("Новости","","news"), 3 => array("Продукты","items","items"), 5 => array("Дискография","","records"),     6 => array("Фото","topic_pics","pics"),);
    $pg_stores = array(1 => array("Москва"), 2 => array("Регионы"));
#####################################################################################################################################
## Global declarations
#####################################################################################################################################
    if(!$_SERVER) $_SERVER = &$HTTP_SERVER_VARS;
    if(!$_GET) $_GET = &$HTTP_GET_VARS;
    if(!$_POST) $_POST = &$HTTP_POST_VARS;
    if(!$_COOKIE) $_COOKIE = &$HTTP_COOKIE_VARS;
    if(!$_FILES) $_FILES = &$HTTP_POST_FILES;
    $Z = &$GLOBALS;
    $pg_id = intval($_GET['id']);
    $pg_id1 = intval($_GET['id1']);
    $pg_id2 = intval($_GET['id2']);
    $pg_id3 = $_GET['id3'];
    $pg_id4 = intval($_GET['id4']);
    $pg_pgid = intval($_GET['pg'])==0 ? 1 : intval($_GET['pg']);
    $pg_sf = intval($_GET['sf']);
    $pg_so = intval($_GET['so']);
    $pg_qt = intval($_GET['qt']);
    $pg_mode = $_GET['mode'];
    $pg_self = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

    $pg_path=$_GET['path'];
    $pg_paths=explode("/", $pg_path);
    $pg_year=$pg_paths[1];
    $pg_number=$pg_paths[2];
    
    $pg_source=$_GET['source'];


    //language set
    $la=array("ru","en","fr");
    $lang=isset($_GET['lang'])?$_GET['lang']:$HTTP_COOKIE_VARS["lang"];
    if (!in_array($lang,$la)) $lang="ru";
    setcookie("lang", $lang, time()+315360000);

//    $pg_lng = intval($_GET['lng']?$_GET['lng']:$_SESSION['lng']);

    $pg_lng = $lang;

#####################################################################################################################################
## Global functions
#####################################################################################################################################
    function _b($s=NULL) { return $s?"<b>".$s."</b>":""; }
    function _i($s=NULL) { return $s?"<i>".$s."</i>":""; }
    function _p($s=NULL,$p=NULL) { return $s?"<p".$p.">".$s."</p>":""; }
    function _a($h,$s,$p=NULL) { return "<a href=".$h.$p.">".$s."</a>"; }
    //function _html($s) { return strip_tags(htmlspecialchars($s)); }
    ## Formats global error message
    function _err($f=NULL,$s=NULL) {
        global $pg_err, $pg_errmsg;
        $pg_err = true;
        return $pg_errmsg .= $s ? "<b>".$f.":</b> ".$s."<br>" : $f."<br>";
    }
    ## Dies friendly
    function _die($s=NULL) {
        die("<html><head><link rel=stylesheet type=text/css href=style.css></head><body class=no>$s</body></html>");
    }
    ## Formats size of file friendly
    function _fsize($v) {
        if(round($v/pow(1024,3))>0) return sprintf("%01.1f Gb", $v/pow(1024,3));
        elseif(round($v/pow(1024,2))>0) return sprintf("%01.1f Mb", $v/pow(1024,2));
        elseif(round($v/1024)>0) return sprintf("%01.1f Kb", $v/1024);
        else return $v." B";
    }

    function _lng1($v) {global $r,$pg_lng,$pg_slng; return $pg_lng==2?($r[$v.$pg_slng]?$r[$v.$pg_slng]:$r[$v.'_ru']):$r[$v.'_ru'];}
    function _lng2($s1,$s2) {global $pg_lng; return $pg_lng==2?($s2?$s2:$s1):$s1;}



    ## Connects to MySQL server; _dies if not
    function _db() {
        global $pg_db;
        if(!$pg_db = mysql_connect(AppDBHost, AppDBUser, AppDBPwd)) _die(_err("MySQL", "База данных на профилактике"));
        @mysql_select_db(AppDBName);
    }
    ## Returns recordset
    function _db_exe($s, $b=0) {
        global $pg_err, $pg_errmsg;
        #print strip_tags($s)."<br>";
        $r = @mysql_query($s);
        if(mysql_errno()!=0&&!$b) {
            _err("Query", strip_tags($s));
            _err("MySQL ".mysql_errno(), mysql_error());
            _die($pg_errmsg);
        }
        return $r ? $r : false;
    }
    ## Returns recordset especially for data listing, with sorting and paging
    function _db_lst($s,$n=0,$b=false) {
        global $pg_sort,$pg_sf,$pg_so,$pg_pgid,$pg_sql,$pg_rs,$pg_total_count,$pg_record_count,$pg_page_count;
        if(isset($pg_sort)) {
            if(!is_array($pg_sort)) $pg_sort=array($pg_sort);
            $sf = array_key_exists($pg_sf,$pg_sort) ? $pg_sort[$pg_sf] : $pg_sort[0];
            $s = $s." order by ".$sf.($pg_so>1?' desc':' asc');
        }
        $pg_total_count = mysql_num_rows(_db_exe($s, $b));
        if($n) $s = $s." limit ".($pg_pgid-1)*$n.",".$n;
        $pg_record_count = mysql_num_rows($r = _db_exe($pg_sql = $s, $b));
        $pg_page_count = $n ? ($pg_total_count%$n==0 ? $pg_total_count/$n : floor($pg_total_count/$n) + 1) : 1;
        return $r;
    }
    ## Returns array contains first row of the recordset
    function _db_row($s,$b=false) {
        if($rs = _db_exe($s, $b)) {
            $a = mysql_fetch_array($rs);
            mysql_free_result($rs);
            return $a;
        }
        return false;
    }
    ## Returns first value of first row of the recordset
    function _db_one($s,$b=false) {
        return is_array($a = _db_row($s, $b)) ? $a[0] : false;
    }
    ## Returns base portion of query string according declared parameters, plus $v
    function qs($v='') {
        global $pg_mode, $pg_id, $pg_id1, $pg_id2, $pg_id3, $pg_id4, $pg_pgid;
        $s = '';
        if($pg_mode) $s .= "&mode=".$pg_mode;
        if($pg_id) $s .= "&id=".$pg_id;
        if($pg_id1) $s .= "&id1=".$pg_id1;
        if($pg_id2) $s .= "&id2=".$pg_id2;
        if($pg_id3) $s .= "&id3=".$pg_id3;
        if($pg_id4) $s .= "&id4=".$pg_id4;
        return preg_replace("/^\?&/", "?", "?".$s.$v);
    }
    ## Must (!) cancel caching
    function _no_cache() {
        header("pragma: no-cache");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: no-cache, must-revalidate"); 
    }
    ## Sets russian locale and codepage
    function _rus() {
        header('Content-type: text/html; charset=windows-1251');
        setlocale(LC_TIME,'russian');
    }
    ## Checks if string $s match popular image extensions
    function _is_img($s) {
        $a = explode(".", strtolower($s));
        return preg_match("/(\w|\W)*(\.)?(gif|jpg|jpe|jpeg|png)$/", $a[count($a)-1]) ? true : false;
    }
    ## Returns image or link to file from Resources table
    function _res_by_id($i,$p="") {
        if(!$r = @mysql_fetch_array(_db_exe("select * from _res where res_id=".intval($i)))) return;
        return _is_img($r['ext']) ?
        "<img src=".AppUrl."/res/".$r['file']." border=0 width=".$r['width']." height=".$r['height']." alt=\"".htmlspecialchars($r['name'])."\"$p>" :
        "<a href=".AppUrl."/res/".$r['file'].$p.">".$r['name'].$r['ext']."</a>";
    }
    ## Cuts long string
    function _str_cut($s,$l) { return strlen($s)>$l ? (preg_match("/^[\w\W]{1,".($l-1)."} /", $s, $a) ? $a[0] : substr($s,0,$l))."..." : $s; }
    ## Returns proper string for queries
    function _db_str($s) { return "'".(get_magic_quotes_gpc()?$s:mysql_escape_string($s))."'";}
    ## Checks numeric value
    function _ch_int($n,$v,$nn=0) {
        if(!isset($v)||$v=='') if($nn) _err($n, "поле необходимо заполнить"); else return 'null';
        else if(!is_numeric($v)) _err($n, "поле должно быть числом"); else return $v;
        return 'null';
    }
    ## Checks text value with tags
    function _ch_htm($n,$v,$l,$nn=0) {
        global $pg_err;
        if(!isset($v)||str_replace(" ","",$v)=='') if($nn) _err($n, "поле необходимо заполнить"); else return 'null';
        else if(strlen($v)>$l) _err($n, "длина поля (".strlen($v).") превышает разрешенные (".$l.")"); else return _db_str($v);
        return 'null';
    }
    ## Checks text value without tags
    function _ch_str($n,$v,$l,$nn=0) { return _ch_htm($n,strip_tags($v),$l,$nn); }
    ## Checks e-mail
    function _ch_eml($n,$v,$l,$nn=0) {
        if(isset($v)&&$v!=''&&!preg_match("/^([\w-~_]+\.)*[\w-~_]+@([\w-_]+\.){1,3}\w{2,4}$/", $v)) { _err($n, "неверный формат адреса e-mail"); return "null"; }
        return _ch_str($n,$v,$l,$nn);
    }
    ## Checks date/datetime value
    function _ch_dtm($n,$q) { return mktime($q[$n."_hh"],$q[$n."_mi"],$q[$n."_ss"],$q[$n."_mm"],$q[$n."_dd"],$q[$n."_yy"]); }
    ## Checks date/datetime form field
    function _ch_ids($v) { return preg_match("/^(-?\d+, *)*-?\d+ *$/", $v) ? str_replace(" ", "", $v) : "-1"; }

    function _stat($t,$p) {
        $S = &$_SERVER;
        if(!$_SESSION['stat_'.$t.'_'.$p]) _db_exe("insert into _stat (topic_id,page_id,url,qs,referer,agent,ip,date) values (".$t.",".$p.","._db_str($S['PHP_SELF']).","._db_str($S['QUERY_STRING']).","._db_str($S['HTTP_REFERER']).","._db_str($S['HTTP_USER_AGENT']).","._db_str($S['REMOTE_ADDR']).",unix_timestamp())");
        $_SESSION['stat_'.$t.'_'.$p] = 1;
    }
    
#####################################################################################################################################
## Classes
#####################################################################################################################################
    
    ## Resources
    class res {
        var $obj, $upl, $id, $folder, $name, $descr, $file, $ext, $type, $w, $h, $enable;
        function res($n,$f,$l,$b=0,$nn=0) {
            global $pg_err;
            if($pg_err) return;
            $this->id = intval($_POST[$f]);
            $this->obj = $_FILES[$f.'_file'];
            $this->upl = is_uploaded_file($this->obj['tmp_name']);
            $this->enable = 1;
            if($this->upl) {
                if($this->obj['error']!=0) _err($this->obj['name'], "невозможно сохранить файл");
                elseif($this->obj['size']>$l) _err($this->obj['name'], "размер файла ("._fsize($this->obj['size']).") превышает разрешенные "._fsize($l));
                elseif($b&&!_is_img($this->obj['name'])) _err($this->obj['name'], "файл должен быть графическим");
                else {
                    $this->field = $f;
                    $this->size = $this->obj['size'];
                    $this->type = $this->obj['type'];
                    $wh = @getimagesize($this->obj['tmp_name']);
                    if(!is_array($wh)) $wh = array(0,0);
                    $this->w = $wh[0];
                    $this->h = $wh[1];
                    $r = explode(".", $this->obj['name']);
                    $this->ext = is_array($r) ? ".".strtolower($r[count($r)-1]) : "";
                    $this->file = strtolower(md5(uniqid(rand(),1))).$this->ext;
                    if(!@move_uploaded_file($this->obj['tmp_name'], '../res/'.$this->file)) $pg_err .= _err($this->obj['name'], "ошибка при сохранении файла");
                }
            }
            elseif($this->obj['name']) _err($n, "размер файла превышает системный лимит (".ini_get("upload_max_filesize").")");
            elseif($this->id==0&&$nn) _err($n, "необходимо выбрать файл");
        }

        function save($qt) {
            global $pg_err,$pg_errmsg;
            if($pg_err) {
                if($this->upl) @unlink('../res/'.$this->file);
                return;
            }
            $folder = intval($this->folder);
            $name = $this->name ? $this->name : "'Без названия'";
            $descr = $this->descr ? $this->descr : "null";
            $type = $this->type ? _db_str($this->type) : "null";
            $file = _db_str($this->file);
            $ext = _db_str($this->ext);
            $w = intval($this->w);
            $h = intval($this->h);
            $size = intval($this->size);
            $st = intval($this->enable);
            if($pg_err) return;
            if($qt==1&&$this->size>0) {
                _db_exe("insert into _res (ref_id,name,descr,type,file,size,ext,width,height,enable,updated) values ($folder,$name,$descr,$type,$file,$size,$ext,$w,$h,$st,unix_timestamp())");
                $this->id = intval(@mysql_insert_id());
            } elseif($qt==2) {
                $old = _db_one("select file from _res where res_id=".intval($this->id));
                _db_exe("update _res set ref_id=$folder,name=$name,descr=$descr,".($this->upl?"file=$file,type=$type,size=$size,ext=$ext,width=$w,height=$h,":"")."enable=$st,updated=unix_timestamp() where res_id=".$this->id);
                if($this->upl&&!$pg_err) @unlink('../res/'.$old);
            }
            if($pg_err) @unlink('../res/'.$this->file);
            return $this->id;
        }
        
        function del() {
            if($this->id>0) _db_exe("delete from _res where res_id=".$this->id);
            if(!$pg_err) @unlink('../res/'.$this->file);
        }
    }
?>