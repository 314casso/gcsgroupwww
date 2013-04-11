<?
global $elect_do, $quest, $doc, $forprint;

$quest = trim ($quest);

if (function_exists('AssignVars') === false)
{
        function AssignVars($assign_vars, $template, $pattern = "/{(.*?)}/")
        {
                $size = preg_match_all($pattern, $template, $found_vars);

                for($i = 0; $i < $size; $i++)
                {
                        $template = str_replace($found_vars[0][$i], $assign_vars[$found_vars[1][$i]], $template);
                }

                //возвращаем шаблон после замены в нем ключей
                return $template;
        }
}

if (($elect_do == $id && $quest != "") || $forprint != '') {
	if ($elect_do == $id && $quest != "") {
		// Submit vote to the database
		$qst = mysql_fetch_array(mysql_query("select quest{$quest}_n from engine_ELECT where doc_id=".$this->id));
		$n=$qst["quest{$quest}_n"]+1;
		mysql_query("update engine_ELECT set quest{$quest}_n=$n") or die (mysql_error());
		$this->body=$this->spec["msg"];
		$this->body .= "<br><br>";
		$this->spec['quest'.$quest.'_n'] = $this->spec['quest'.$quest.'_n'] + 1;
		$elect_do = 0;
		$quest = '';
	} else {
		$this->body = '';
	}

	// Now list all existing votes

	$this->body .= "<table cellpadding=0 cellspacing=4>
		<tr><td colspan=3 class=elect_question>Результаты опроса \"".($this->spec["question"]).
		"\"</td></tr>";

	$total_votes = $this->spec["quest1_n"] + $this->spec["quest2_n"] + $this->spec["quest3_n"] + $this->spec["quest4_n"]
			 + $this->spec["quest5_n"] + $this->spec["quest6_n"] + $this->spec["quest7_n"] + $this->spec["quest8_n"]
			  + $this->spec["quest9_n"] + $this->spec["quest10_n"];

	$this->body .= "<tr><td colspan=3 class=elect_question>Всего проголосовало: $total_votes</td></tr>";

	for ($i=1; $i<=10; $i++){
		if ($this->spec["quest$i"]) {
			$perc = intval ($this->spec["quest".$i."_n"] / $total_votes * 100 + .5);
			$this->body.= "<tr><td class=elect_td>".$this->spec["quest$i"]."</td><td class=elect_td>".
					$this->spec["quest".$i."_n"]." (".$perc.
					"%)</td><td><img src='/engine_lib/engine/doc_types/ELECT/img/z.gif' width=$perc height=5 valign=baseline></td></tr>";
		}
	}
	$this->body .= "</table>";
}
else
{
	if (empty($this->spec['elect_format']))
	{
		$elect_format = '<form action="{elect_url}" method="POST" name="frmVote{id}">
<table cellpadding="0" cellspacing="4">
  <tr><td colspan="2" class="elect_question">{question}</td></tr>
  {questions}
  <tr><td class=elect_td colspan="2" align="center">
  {button}
  </td></tr>
</table>
<input type="hidden" name="elect_do" value="{id}">
<input type="hidden" name="doc" value="{id}">
</form>';
	}
	else
	{
		$elect_format = $this->spec['elect_format'];
	}

	if (empty($this->spec['elect_item']))
	{
		$elect_item = '<tr><td class="elect_td">{quest_value}</td><td class="elect_td"><input type="radio" name="quest" value="{quest_id}"></td></tr>';
	}
	else
	{
		$elect_item = $this->spec['elect_item'];
	}

	$vars = array();
	foreach($this as $param => $value)
	{
		if (!is_array($value))
		{
			$vars[$param] = $value;
		}
	}

	foreach($this->spec as $param => $value)
	{
		if (!is_array($value))
		{
			if (!is_int($param))
			{
				$vars[$param] = $value;
			}
		}
	}

	$vars['elect_url'] = geturl($id);
	$vars['button_text'] = $vars['button'];
	$vars['questions'] = '';

	for ($i=1;$i<=10;$i++)
	{
		if ($vars['quest'.$i])
		{
			$vars['questions'] .= AssignVars(array('quest_value' => $vars['quest'.$i],
							       'quest_id'    => $i), $elect_item);
		}
	}

	if ($vars['button'])
	{
		if (strpos($vars['button'], '<') === 0)
		{
			$vars['button'] = $vars['button'];
		}
		else
		{
			$vars['button'] = '<input class="elect_submit" value="'.htmlspecialchars($vars["button"]).'" type="submit" />';
		}
	}
	else
	{
		$vars['button'] = '<input class="elect_submit" value="Отправить" type="submit" />';
	}

	$this->body = AssignVars($vars, $elect_format);
}
?>

