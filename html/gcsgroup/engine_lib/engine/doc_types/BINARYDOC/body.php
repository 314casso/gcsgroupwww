<?
global $engine_show_root,$engine_show_htroot;

if (file_exists($engine_show_root.'/engine/documents/document'.$this->id.'.'.$this->spec['ext']))
{
	$size = filesize($engine_show_root.'/engine/documents/document'.$this->id.'.'.$this->spec['ext']);

	$i=0;
	$iec = array("Á", "Êá", "Ìá", "Ãá", "Òá");
	while ((($size/1024)>1)&&($i<5))
	{
		$size=$size/1024;
		$i++;
	}
//	$size_text = substr($size,0,strpos($size,'.')+2).' '.$iec[$i];
        $size_text = substr($size.'.0',0,strpos($size.'.0','.')+2).' '.$iec[$i];
//      peredelat na sprintf normalnyi


	$this->body = '<a href="'.$engine_show_htroot.'/engine/documents/document'.$this->id.'.'.$this->spec['ext'].'">'.$this->name.'</a> (.'.$this->spec['ext'].', '.$size_text.')';
}

?>
