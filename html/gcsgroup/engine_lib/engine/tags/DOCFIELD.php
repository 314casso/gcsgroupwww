<?
//echo $type."!!!";exit;
global $def_counter1,$def_counter2,$def_counter3;


if (!$doc_id)
{

	$d=$doc;
}
else
{

	$d=new Document($doc_id,'1',$ptitle);
}

if (strtolower($type)=='id')
{
	$doc_field = $d->id;
}
elseif (strtolower($type)=='name')
{
	if ($d->type=='NEW')
	{
		$doc_field = $d->spec[header];
	}
        else
        {
                $doc_field =$d->name;
	}
}
elseif (strtolower($type)=='caption_long')
{
	$doc_field = str_replace("\n","<br>",$d->caption_long);
}
elseif (strtolower($type)=='caption_medium')
{
	$doc_field = str_replace("\n","<br>",$d->caption_medium );
}
elseif (strtolower($type)=='caption_short'){
	$doc_field = str_replace("\n","<br>",$d->caption_short );
}
elseif (strtolower($type)=='code')
{
	$doc_field = $d->code;
}
elseif (strtolower($type)=='creation_date')
{
	$doc_field = $d->creation_date ;
}
elseif (strtolower($type)=='user')
{
	$doc_field = $d->user;
}
elseif (strtolower($type)=='folder')
{
	$doc_field = $d->folder;
}
elseif (strtolower($type)=='folderid')
{
	$doc_field = $d->folderid;
}
elseif (strtolower($type)=='meta')
{
	$doc_field = $d->meta;
}
elseif (strtolower($type)=='title')
{	$doc_field = $d->title;

}
elseif (strtolower($type)=='resume')
{
	$doc_field = $d->resume;
}
elseif (strtolower($type)=='doctoshow')
{
	if ($d->type=='FOLDER')
	{
		$doc_field = $d->spec['doctoshow'];
	}
        else
        {
                $doc_field = $d->spec['id'];
        }
}
elseif (strtolower($type)=='counter1')
{
	if (trim($d->counter1))
	{
		$doc_field = $d->counter1;
	}
	else
	{
		$doc_field = $def_counter1;
        }
}
elseif (strtolower($type)=='counter2')
{
	if (trim($d->counter2))
	{
		$doc_field = $d->counter2;
	}
	else
	{
		$doc_field = $def_counter2;
	}
}
elseif (strtolower($type)=='counter3')
{
	if (trim($d->counter3))
	{
		$doc_field = $d->counter3;
	}
	else
	{
		$doc_field = $def_counter3;
	}
}
elseif (strtolower($type)=='actimg')
{
	if (file_exists($engine_show_root."engine/doc_icons/actimg".$d->id.".gif"))
	{
		$doc_field = $engine_show_htroot."/engine/doc_icons/actimg".$d->id.".gif";
	}
        elseif (file_exists($engine_show_root."engine/doc_icons/actimg".$d->id.".jpg"))
        {
        	$doc_field = $engine_show_htroot."/engine/doc_icons/actimg".$d->id.".jpg";
	}
	else
	{
		$doc_field = $engine_show_htroot."/engine_lib/engine/img/0.gif";
	}
}
elseif (strtolower($type)=='unactimg')
{
	if (file_exists($engine_show_root."engine/doc_icons/unactimg".$d->id.".gif"))
	{
		$doc_field = $engine_show_htroot."/engine/doc_icons/unactimg".$d->id.".gif";
	}
        elseif (file_exists($engine_show_root."engine/doc_icons/unactimg".$d->id.".jpg"))
        {
		$doc_field = $engine_show_htroot."/engine/doc_icons/unactimg".$d->id.".jpg";
	}
        else
        {
        	$doc_field = $engine_show_htroot."/engine_lib/engine/img/0.gif";
	}
}
else
{
	$doc_field = $d->body;
}

if (isset($check_visiblity))
{
	if ($d->visible)
	{
		if (isset($prefix))
		{
			echo $prefix;
		}

		echo $doc_field;

		if (isset($postfix))
		{
			echo $postfix;
		}
	}
}
else
{
	if (isset($prefix))
	{
		echo $prefix;
	}

	echo $doc_field;

	if (isset($postfix))
	{
		echo $postfix;
	}
}
?>