<?
global $engine_show_htroot;
if (!$doc_id){

        echo $doc->geturl();
        }
else {
        echo geturl($doc_id);
        }

?>