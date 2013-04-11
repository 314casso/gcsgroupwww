<?
//echo $doc->body;
if (!$doc_id)
{
	$body = $doc->body;
	$visible = $doc->visible;
}
else
{
	$d = new Document($doc_id);

	$visible = $d->visible;
	$body = $d->body;

}

if (isset($check_visiblity))
{
	if ($visible)
	{
		if (isset($prefix))
		{
			echo $prefix;
		}

		echo $body;

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

	echo $body;

	if (isset($postfix))
	{
		echo $postfix;
	}
}

?>