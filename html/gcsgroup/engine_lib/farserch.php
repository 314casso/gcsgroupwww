<?

			$udm = udm_alloc_agent('mysql://mns_user:mns_pass@localhost/mnogosearch/','single'); 
			if ((! Udm_Load_Ispell_Data($udm,UDM_ISPELL_TYPE_AFFIX,'en','/usr/lib/ispell/russian.aff',0)) ||
			        (! Udm_Load_Ispell_Data($udm,UDM_ISPELL_TYPE_SPELL,'ru','/usr/dict/russian.dict',1))) {
			      exit;
			      }

				  

			$query=$search;
			Udm_Set_Agent_Param($udm,UDM_PARAM_QUERY,$query);
			Udm_Set_Agent_Param($udm,UDM_PARAM_PAGE_NUM,(int)$page);
			Udm_Set_Agent_Param($udm,UDM_PARAM_PAGE_SIZE,20);
			Udm_Set_Agent_Param($udm, UDM_PARAM_TRACK_MODE,UDM_TRACK_ENABLED);

			udm_add_search_limit ($udm,UDM_LIMIT_URL,$url);
			$l=Udm_Find($udm,"");
			$count=udm_get_res_param($l,UDM_PARAM_NUM_ROWS );
			$total=udm_get_res_param($l, UDM_PARAM_FOUND);
			$pages=($total-$total%20)/20;
			if ($total%20)$pages++;
			echo "<b>Страницы:</b>";
			for($i=0;$i<$pages;$i++){
				if ($i!=$page){
					echo "<a href=?page=$i&search=$search&url=$url>".($i+1)."</a>&nbsp;";
					}
				else 
					echo "<b>".($i+1)."</b>&nbsp;";
				}
			for ($i=0;$i<$count;$i++){
				global $deftitle;
				echo "\n".udm_get_res_field ($l,$i,UDM_FIELD_URL);
				}
			udm_free_res($l);
			udm_free_ispell_data($udm);
			udm_free_agent($udm);
			

?>
