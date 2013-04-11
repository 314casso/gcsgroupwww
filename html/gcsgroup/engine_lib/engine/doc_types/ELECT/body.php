<?
/*
CREATE TABLE `engine_ELECT_IP` (
`elect_id` BIGINT NOT NULL ,
`elect_ip` VARCHAR( 8 ) NOT NULL ,
`elect_question` TINYINT NOT NULL ,
`elect_time` DATETIME NOT NULL ,
PRIMARY KEY ( `elect_id` , `elect_ip` )
);
*/
global $elect_do, $quest, $doc, $forprint;

$quest = intval($quest);

if (function_exists('encode_ip') === false)
{	function encode_ip($dotquad_ip)
	{
		$ip_sep = explode('.', $dotquad_ip);
		return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
	}
}

if (function_exists('decode_ip') === false)
{
	function decode_ip($int_ip)
	{		$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
		return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
	}
}

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

if (($elect_do == $id && $quest != 0) || $forprint != '')
{	if (empty($this->spec['elect_message']))
	{		$elect_message = '{message}<br /><br />';
	}
	else
	{		$elect_message = $this->spec['elect_message'];
	}

	$vars = array();
	if ($elect_do == $id && $quest != "")
	{		if ($this->spec['elect_type'] == 1)
		{			if (isset($_COOKIE['elect_'.$this->id]))
			{				$do_elect = false;
				$error_message = 'Извините, Вы не можете принять участие в этом опросе повторно."';
			}
			else
			{				$do_elect = true;
				setcookie('elect_'.$this->id, '1', time()+60*60*24*30, '/');
			}
		}
		elseif ($this->spec['elect_type'] == 2)
		{			$client_ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
			$user_ip   = encode_ip($client_ip);

			$sql = 'SELECT *
			          FROM engine_ELECT_IP
			         WHERE elect_id = "'.$this->id.'" AND elect_ip = "'.$user_ip.'";';

			if (!$result = mysql_query($sql))
			{				die($sql);
			}
			else
			{				if (mysql_num_rows($result) != 0)
				{					$do_elect = false;
					$error_message = 'Извините, Вы не можете принять участие в этом опросе повторно.';
				}
				else
				{					$sql = 'INSERT INTO engine_ELECT_IP (elect_id, elect_ip, elect_question, elect_time)
					                             VALUES ('.$this->id.', "'.$user_ip.'", "'.$quest.'", NOW());';

					if (!$result = mysql_query($sql))
					{						die($sql);
					}
					else
					{						$do_elect = true;
						$error_message = '';
					}
				}
			}
		}
		else
		{			$do_elect = true;
			$error_message = '';
		}

		if ($do_elect)
		{
			$sql = 'UPDATE engine_ELECT
		                   SET quest'.$quest.'_n = quest'.$quest.'_n + 1
		                 WHERE doc_id = '.$this->id;

			if (!$result = mysql_query($sql))
			{
				die($sql);
			}

			$vars['message'] = AssignVars(array('message' => $this->spec["msg"]), $elect_message);
			$this->spec['quest'.$quest.'_n'] = $this->spec['quest'.$quest.'_n'] + 1;
		}
		else
		{			$vars['message'] = AssignVars(array('message' => $error_message), $elect_message);;
		}

		$elect_do = 0;
		$quest = '';
	}
	else
	{
		$vars['message'] = '';
	}

	if (empty($this->spec['elect_voted']))
	{		$elect_voted = '{message}<table cellpadding="0" cellspacing="4">
<tr><td colspan="3" class="elect_question">Результаты опроса "{question}"</td></tr>
<tr><td colspan=3 class=elect_question>Всего проголосовало: {total_votes}</td></tr>
{questions}
</table>
';
	}
	else
	{		$elect_voted = $this->spec['elect_voted'];
	}

	if (empty($this->spec['elect_voted_item']))
	{
		$elect_voted_item = '<tr><td class="elect_td">{quest_value}</td><td class="elect_td">{quest_n} ({quers_percent}%)</td><td><img src="/engine_lib/engine/doc_types/ELECT/img/z.gif" width="{quers_percent}" height="5" valign="baseline"></td></tr>';
	}
	else
	{
		$elect_voted_item = $this->spec['elect_voted_item'];
	}


	$total_votes = 0;
	for($i=1; $i<=10; $i++)
	{		$total_votes += $this->spec['quest'.$i.'_n'];
	}

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

	for ($i=1; $i<=10; $i++)
	{
		if ($this->spec["quest$i"])
		{
			$percent = ($total_votes != 0) ? intval($this->spec['quest'.$i.'_n']/$total_votes*100) : 0;

			$vars['questions'] .= AssignVars(array('quest_value'   => $vars['quest'.$i],
							       'quest_id'      => $i,
							       'quest_n'       => $vars['quest'.$i.'_n'],
							       'quers_percent' => $percent), $elect_voted_item);
			/*
			$this->body.= "<tr><td class=elect_td>".$this->spec["quest$i"]."</td><td class=elect_td>".
					$this->spec["quest".$i."_n"]." (".$perc.
					"%)</td><td><img src='/engine_lib/engine/doc_types/ELECT/img/z.gif' width=$perc height=5 valign=baseline></td></tr>";
			*/
		}
	}

	$this->body = AssignVars($vars, $elect_voted);
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

