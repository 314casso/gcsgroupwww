<?
        if (ctype_digit($linkid))
        {
                $sql_where = 'id = "'.$linkid.'"';
        }
        else
        {
                $sql_where = 'code = "'.$linkid.'"';
        }
	 if (!$check_yes) $check_yes = 100;

        $sql = 'SELECT id FROM
                engine_documents
                WHERE '.$sql_where;

        //Получили id документа на который ссылаемся

        $result  = @mysql_query($sql);

        if (!result)
        {
                die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error());
        }

        $row     = @mysql_fetch_array($result, MYSQL_ASSOC);
        $link_id = $row['id'];
        $doc_id  = $id;

        //если мы ссылаемся не сами на себя, то
        //производим обновление добавление и обновление
        if ($link_id != $doc_id)
        {
                $sql = 'DESCRIBE engine_LINK';

                $result = @mysql_query($sql);

                if (!$result)
                {
                        die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error());
                }

                while($field = mysql_fetch_array($result, MYSQL_ASSOC))
                {
                        $fields[$field['Field']] = $field;
                }

                $sql = 'SELECT *
                        FROM engine_LINK
                        WHERE doc_id="'.$doc_id.'"';

                $result = @mysql_query($sql);

                if (!result)
                {
                        die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error());
                }

                if (mysql_num_rows($result) == 0)
                {
                        if (empty($fields['link_external']))
                        {
                                $sql = 'INSERT INTO engine_LINK (doc_id, linkid, status)
                                                         VALUES ("'.$doc_id.'", "'.$link_id.'", "'.$check_yes.'")';
                        }
                        else
                        {
                                $sql = 'INSERT INTO engine_LINK (doc_id, linkid, link_external, status )
                                                         VALUES ("'.$doc_id.'", "'.$link_id.'", "'.mysql_real_escape_string($link_external).'", "'.$check_yes.'")';
                        }

                        $result = mysql_query($sql);
                }
                else
                {
                        if (empty($fields['link_external']))
                        {
                                $sql='UPDATE engine_LINK
                                         SET linkid = "'.$link_id.'",
						    status = "'.$check_yes.'"
                                       WHERE doc_id="'.$doc_id.'"';
                        }
                        else
                        {
                                $sql='UPDATE engine_LINK
                                         SET linkid = "'.$link_id.'",
                                             link_external = "'.mysql_real_escape_string($link_external).'",
						    status = "'.$check_yes.'"
                                       WHERE doc_id="'.$doc_id.'"';
                        }

                        $result = mysql_query($sql);
                }

                if (!result)
                {
                        if (mysql_errno() == 1054)
                        {
                                die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error().'<br \>Скорее всего вам необходимо <b>обновить версию движка</b>.');
                        }
                        else
                        {
                                die('Ошибка во время выполнения SQL запроса:<br \>'.$sql.'<br \>'.mysql_error());
                        }
                }
        }

?>
