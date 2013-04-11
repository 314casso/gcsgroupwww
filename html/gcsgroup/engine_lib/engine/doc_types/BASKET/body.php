<?php
/*

CREATE TABLE `engine_BASKET` (
`doc_id` INT NOT NULL ,
`basket_format` TEXT NOT NULL ,
`basket_line` TEXT NOT NULL ,
PRIMARY KEY ( `doc_id` )
) TYPE = MYISAM ;

*/

function Add2Basket($item_id, $item_count, &$item_data)
{
	$sql = 'SELECT *
	        FROM engine_documents
	        WHERE id = "'.$item_id.'"';

	if (!$result = mysql_query($sql))
	{
		die($sql);
	}

	if ($row = mysql_fetch_array($result))
	{
		if ($row['type'] == 'CATALOGITEM')
		{
			if ($item_count == 0)
			{
				$item_count = 1;
			}

			$item_data[$row['id']] += $item_count;
			if ($item_data[$row['id']] <= 0)
			{
				unset($item_data[$row['id']]);
			}
		}
	}
}

$this->body = '';

$sessiondata = isset($_COOKIE[$this->code.'_products']) ? unserialize(stripslashes($_COOKIE[$this->code.'_products'])) : array();

$basket_add = intval($_GET['add']);
if (is_array($_POST['items']))
{	$items = $_POST['items'];
	foreach($items as $item_id => $item_count)
	{		if (intval($item_count) > 0)
		{			$sessiondata[$item_id] = intval($item_count);
		}
		else
		{			unset($sessiondata[$item_id]);
		}
	}
}
elseif ($basket_add > 0)
{
	$basket_count = intval($_GET['count']);
	Add2Basket($basket_add, $basket_count, $sessiondata);
}

if (isset($_POST['order']))
{	$lang['name'] = 'Ф.И.О.';
	$lang['mail'] = 'E-mail';
	$lang['phone'] = 'Контактный телефон';
	$lang['adress'] = 'Адрес';
	$lang['extended'] = 'Дополнительная информация';
	$result = '';

	foreach($_POST['user'] as $type => $value)
	{		$result .= $lang[$type].': '.htmlspecialchars($value)."\r\n";
	}

	$result .= "\r\n".'=======================ЗАКАЗ======================='."\r\n\r\n";

	$i = 1;
	foreach($sessiondata as $item_id => $item_count)
	{		$d = new document($item_id, false);
		$result .= $i.'. '.$d->spec['name'].' ['.$d->id.'] ('.$item_count.' шт.)'."\r\n";
	}

	mail("ereih@belti.ru", "Новый заказ номер ".intval(time()/100), $result, "From: no-reply@fencingfuture.org");
	mail($_POST['user']['mail'], "Новый заказ номер ".intval(time()/100), $result, "From: no-reply@fencingfuture.org");
	$sessiondata = array();

	$this->body = 'Ваш заказ успешно отправлен на почту модератору. С вами свяжутся в ближайшее время.';
}
elseif (empty($sessiondata))
{
	$this->body = '<b>В вашей корзине нет элементов<b>';
}
else
{	$basket_body = '';
	$basket_summ = 0;

	$template = $this->spec['basket_line'];
	foreach($sessiondata as $item_id => $item_count)
	{		$d = new document($item_id, false);
		if ($d->type != 'CATALOGITEM')
		{			continue;
		}
                $i++;

                $vars = array();
                foreach($d as $key_id => $key_value)
                {
                        if ($key_id != 'spec')
                        {
                                $vars['doc_'.$key_id] = $key_value;
                        }
                }

                if (is_array($d->spec))
                {
                        $doc_type = strtolower($d->type);
                        foreach($d->spec as $key_id => $key_value)
                        {
                                if (!is_int($key_id))
                                {
                                        $vars[$doc_type.'_'.$key_id] = $key_value;
                                }
                        }
                }

                $vars['doc_act_image'] = '';
                if (file_exists('engine/doc_icons/actimg'.$vars['doc_id'].'.gif'))
                {
                	$vars['doc_act_image'] = '/engine/doc_icons/actimg'.$vars['doc_id'].'.gif';
                }
		elseif (file_exists('engine/doc_icons/actimg'.$vars['doc_id'].".jpg"))
		{
			$vars['doc_act_image'] = '/engine/doc_icons/actimg'.$vars['doc_id'].'.jpg';
		}
		elseif ($vars['doc_type'] == 'FOLDER')
		{
			$vars['doc_act_image'] = '/engine/doc_icons/default/actfld.gif';
		}
		else
		{
			$vars['doc_act_image'] = '/engine/doc_icons/default/actdoc.gif';
		}

		$vars['doc_unact_image'] = '';
                if (file_exists('engine/doc_icons/unactimg'.$vars['doc_id'].'.gif'))
                {
                	$vars['doc_unact_image'] = '/engine/doc_icons/unactimg'.$vars['doc_id'].'.gif';
                }
		elseif (file_exists('engine/doc_icons/unactimg'.$vars['doc_id'].".jpg"))
		{
			$vars['doc_unact_image'] = '/engine/doc_icons/unactimg'.$vars['doc_id'].'.jpg';
		}
		elseif ($vars['doc_type'] == 'FOLDER')
		{
			$vars['doc_unact_image'] = '/engine/doc_icons/default/uactfld.gif';
		}
		else
		{
			$vars['doc_unact_image'] = '/engine/doc_icons/default/uactdoc.gif';
		}

		$vars['doc_link'] = geturl($d->id);
		$vars['doc_class'] = ($i%2)+1;
		$vars['catalogitem_count'] = $item_count;
		$vars['doc_num'] = $i;
		$basket_summ += $item_count*$d->spec['price'].';';

		$basket_body .= AssignVars($vars, $template);
	}

	$basket_link = geturl($this->id);

	$template = $this->spec['basket_format'];
	$this->body = AssignVars(
				array(
					'body' => $basket_body,
					'summ' => $basket_summ,
					'link' => $basket_link
				), $template);
}

setcookie($this->code.'_products', serialize($sessiondata));
?>
