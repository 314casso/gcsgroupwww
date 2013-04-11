<?
if (!$doc_id)
        $d=$doc;
else
        $d=new Document($doc_id,0);

echo "window.open('".($d->geturl())."?forprint=1".($template != '' ? '&template='.urlencode($template) : '')."','view1','width=500,height=600,menubar=0,resizable=1,status=0,tollbar=0,scrollbars=1,top=0,left=0'); false;";
?>
