<?

include $engine_root.'/engine/link_tree.php';

if (!$parent_doc_spec[status] && $parent_doc_spec[status] != 100 && $parent_doc_spec[status] != 1){
	mysql_query("ALTER TABLE `engine_LINK` ADD `status` INT( 4 ) NOT NULL default '100'") ;
   	/*	echo "<pre>";
   		print_r($parent_doc_spec);	   
   		echo "</pre>";*/
}


if ($parent_doc_spec[linkid])
{
        $ldoc = new document($parent_doc_spec[linkid]);
}

if ($ldoc->code)
{
        $c = $ldoc->code;
}
else
{
        $c = $ldoc->id;
}

if ($parent_doc_spec[status] == 1) $checked = " checked";
$link_doc = '<a href="view.php?action=showdoc&id='.$ldoc->id.'" class="com_link">'.$ldoc->name.'</a>';
$tpl->assign(
              array('{LINK_ID}' => intval($parent_doc_spec['linkid']),
              	    '{LINK_DOC}' => $link_doc,
                    '{LINK_TREE}' => $tree,
                    '{LINK_CODE}'  => $c,
                    '{CHECK_VALUE}'  => $checked,
                    '{LINK_EXTERNAL}' => $parent_doc_spec['link_external']
                    )
            );

?>
