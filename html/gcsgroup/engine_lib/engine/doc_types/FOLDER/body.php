<?

if ($this->id==-1) {
	if  ($this->doctoshow and $this->doctoshow!=-1){
		$doctoshow=new Document($this->doctoshow);
		$this->body=$doctoshow->body;
		$this->name=$doctoshow->name;
		$this->visible=$doctoshow->visible;
		$this->caption_long=$doctoshow->caption_long;
		$this->caption_medium =$doctoshow->caption_medium;
		$this->caption_short =$doctoshow->caption_short;
		}
	else $this->body="";
	}
else {

	if  ($this->spec[doctoshow] and $this->spec[doctoshow]!=-1){
		if ($ptitle != 1){
			$doctoshow=new Document($this->spec[doctoshow]);
			$this->body=$doctoshow->body;
			$this->name=$doctoshow->name;
			$this->visible=$doctoshow->visible;
			$this->caption_long=$doctoshow->caption_long;
			$this->caption_medium =$doctoshow->caption_medium;
			$this->caption_short =$doctoshow->caption_short;
		}
	}
	else {

		$ddd=$doc;
		$doc=$this;
		ob_start(); 
		$ptrn[0]="|(\w+)\s*=\s*'(.+)'|Usi";
		$ptrn[1]="/(\w+)\s*=\s*(.+)($|\s)/Usi";
		$param=$this->spec[format];
		global $dflt_menu_format;

		if ($param==""){
			$param="format='$dflt_menu_format' ";
			}
		for ($j=0;$j<2;$j++){
			preg_match_all($ptrn[$j], $param,$regs,PREG_SET_ORDER);	
			$i=0;
			while($regs[$i][0]){
				${$regs[$i][1]}=$regs[$i][2];
				$i++;
				}
			$param=preg_replace($ptrn[$j],"",$param);
			}
		if (file_exists($engine_root."/engine/tags/MENU.php")){
			$param=$reg[$i][3];
			include($engine_root."/engine/tags/MENU.php");
			}

		$ret_str = ob_get_contents(); 
		ob_end_clean(); 
	
		$this->body=$ret_str;
		$doc=$ddd;
		}
	}

?>