<?
global $engine_show_htroot;
if (!$doc_id){
        $url=$doc->geturl();
        }
else {
        $url=geturl($doc_id);
        }
echo $url.="?forum_doc={$doc->id}";
?>