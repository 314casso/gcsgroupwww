<?

global $engine_show_htroot;
$formatnolink = '<a class="path">ITEM_TEXT</a>';
$did = $doc->id;

$flds = array("caption_long", "caption_medium", "caption_short", "title", "resume");
if (!field || !in_array($field, $flds)) $field="name";

$splitter = trim($splitter);

if (empty($splitter))
{
        $splitter = ' | ';
}

$root = trim($root);

if (empty($root))
{
	if ($lang == 'esp')
	{
		$root = 'Principal';
	}
	elseif ($lang == 'fra')
	{
		$root = 'Principal';
	}
	elseif ($lang == 'eng')
	{
		$root = 'Main';
	}
	else
	{
		$root = 'Главная';
	}
}

if (empty($format))
{
        $format = '<a class="path" href="ITEM_LINK">ITEM_TEXT</a>';
}

$i=0;
while ($did!=-1)
{
        $sql='SELECT *
              FROM engine_documents
              WHERE id="'.$did.'"';

        $result = mysql_query($sql);

        $row    = mysql_fetch_array($result);
        $dpid   = $row['pid'];
        $showit = 1;

        if ($row['type'] == 'FOLDER')
        {
                $sql='SELECT notinpath
                      FROM engine_FOLDER
                      WHERE doc_id="'.$did.'"';

                $result = mysql_query($sql);

                $row1 = mysql_fetch_array($result);

                if ($row1['notinpath'])
                {
                        $showit=0;
                }
        }

        if ($showit)
        {
                if ($row['visible'] && $i)
                {
                        $itemstr = empty($row[$field]) ? $row['name'] : $row[$field];
                        $a[$i++]=str_replace('ITEM_TEXT',$itemstr,str_replace('ITEM_LINK', geturl($row['id']), $format));
                }
                else
                {
                        $itemstr = empty($row[$field]) ? $row['name'] : $row[$field];
                        $a[$i++]=str_replace('ITEM_TEXT', $itemstr, $formatnolink);
                }
        }
        $did = $dpid;
}

if (!empty($doc_root))
{	$root_path = geturl($doc_root);
}
else
{	$root_path = '/';
}

echo str_replace(array('ITEM_TEXT', 'ITEM_LINK'), array($root, $root_path), $format).$splitter;

for ($m= ($i-1); $m>=1; $m--)
{
        echo $a[$m].$splitter;
}

echo $a[$m];

?>
