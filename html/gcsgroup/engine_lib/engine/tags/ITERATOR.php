<?
global $id;

//
//[RAND
//  folder='540'
//  types='FOLDER'
//  recursive=true
//  format='<tr><td>{doc_id}</td><td>{doc_name}</td></tr>'
//  gen_body=1
//  body_pattern='/<li>(.*?)<\/li>/'
//  doc_count=3
//  doc_order=random
//]
//

/*
folder       - ID ����� ��� ��������� � �������� ����� �������� "����". �������� ����� ����� ���� ����� parent, � ���� ������
               ������� ������ ����� ����� ��������.
               �� ��������� ������� �����.
types        - ���� ���������� ������� ����� ����������. ����������� ���� ���������� ����� ������� (���� ��������� �����)
               ��� ��������.
               �� ��������� ��� ���������.
recursive    - ���� �� ����������� ����� �� ��������� ���������� (��������, �����, ��������� �����).
               �� ��������� ���������.
format       - ������ ������ ����. ������ ������� ����� �������� ����������� � �������� ������� ����� ���������� ��
               �������� ��������� ��� �� ������, ���� ������ �������� ���.
               ����� � ������� ����� �������������� ���������� ���� {���_���������_��������}
               �� ��������� ����.
               ������: {folder_doc_id}
               ������: {doc_id}
gen_body     - ���� � ������������� ��������� ���� ���������
               �� ��������� ���������.
body_pattern - ������ ��� ������� �� ���� ���������. ���������� ��� ������� ������������ ����� �� ���������. ��������
               ������ ��� ���������� gen_body.
               �� ��������� ����.
doc_count    - ���������� ����������, ������� ���� �������.
               �� ��������� ���.
doc_order    - ���������� ��������� ����������.
               �� ��������� ���.
               ��������� ��������:
               date_desc - ���� � �������� �������
               date      - ���� � ���������� �������
               random    - ��������
               ord       - �� ������������ ������ �����
               name      - �� �����

rubrics      - ID ������ (����� �������), � ������� ���� ���� ��������

separator    - �����������. ����������� ����������� � ����� ������� ������. ����� ����������� � ���,
               ��� ����� ���������� �������� �� �� ���������.

start        - ����������� �������� � ������ ���������

�� ��� ��������� ��������� ����������� ���������
*/

if (function_exists('AssignVars') === false)
{
        function AssignVars($assign_vars, $template, $pattern = "/{(.*?)}/")
        {
                $size = preg_match_all($pattern, $template, $found_vars);

                for($i = 0; $i < $size; $i++)
                {
                        $template = str_replace($found_vars[0][$i], $assign_vars[$found_vars[1][$i]], $template);
                }

                //���������� ������ ����� ������ � ��� ������
                return $template;
        }
}

if ($folder == 'parent') {
    $folder = $doc->pid;
}

$folder_id = intval($folder);

if ($folder_id == 0) {
    $folder_id = $doc->id;
}

if ((!isset($recursive))||($recursive == 0))
{
    $pids = $folder_id;
}
else
{
        $pid = $folder_id;
        $pids[] = $pid;
        do
        {
                //�������� ��������� � ������� ����� ���� "����"
                $sql = 'SELECT id
                        FROM engine_documents
                        WHERE pid IN ("'.$pid.'")
                          AND type IN ("FOLDER", "NEWSGROUP", "CATALOG")
                          AND visible = 1';

                $have_parents = false;
                if ($result = @mysql_query($sql))
                {
                        if (@mysql_num_rows($result))
                        {
                                $pid = array();
                                while ($row = mysql_fetch_array($result , MYSQL_ASSOC))
                                {
                                        $pid[] = $row['id'];
                                        $pids[] = $row['id'];
                                }
                                $pid = implode('","', $pid);
                                $have_parents = true;
                        }

                }
                else
                {
                        echo '������ MySQL: '.$sql.'<br>'.mysql_error();
                }
        }
        while ($have_parents);
        $pids = implode('","', $pids);
}

if (!empty($types))
{
        $doc_types = explode(',', $types);
}

if ((isset($gen_body))&&($gen_body != 0))
{
        $gen_body = 1;
}
else
{
        $gen_body = 0;
}

$limit = '';
$doc_count = intval($doc_count);
if ($doc_count != 0)
{
        $page = intval($page) ? intval($page) : intval($_REQUEST['page']);
        $limit = 'LIMIT '.(($page*$doc_count)+intval($start)).', '.$doc_count;
}

$order = '';
if (!empty($doc_order))
{
        $order = 'ORDER BY ';
        switch ($doc_order)
        {
                case 'date_desc': $order .= 'creation_date DESC';
                                  break;
                case 'date'     : $order .= 'creation_date';
                                  break;
                case 'random'   : $order .= 'RAND()';
                                  break;
                case 'ord'      : $order .= 'ord';
                                  break;
                case 'name'     : $order .= 'name';
                                  break;
                case 'ordname'  : $order .= 'ord, name';
                          break;
                default         : $order .= 'RAND()';
                                  break;
        }
}

$types_in = implode('","', $doc_types);

if (!empty($types_in))
{
        $types_in = ' AND type IN ("'.$types_in.'")';
}
else
{
        $types_in = '';
}

$rubrics_in = '';
if (!empty($rubrics))
{
    $sql = 'SELECT *
            FROM engine_docsinrubriques
            WHERE rub IN ('.$rubrics.') AND `in` != 0;';

    if (!$result = @mysql_query($sql))
    {
           echo '������ MySQL: '.$sql.'<br>'.mysql_error();
    }
    else
    {
        $rubrics_in = ' AND id IN (';

        while ($row = @mysql_fetch_array($result))
        {
            $rubrics_in .= $row['doc'].', ';
        }

        $rubrics_in = substr($rubrics_in, 0, -2);
        $rubrics_in .= ')';
    }
}

//�������� ��������� � ������� ����� ���� "����"
$sql = 'SELECT id, ord
        FROM engine_documents
        WHERE visible = 1 AND pid IN ("'.$pids.'")
        '.$types_in.'
        '.$rubrics_in.'
        '.$order.'
        '.$limit;

if ($result = @mysql_query($sql))
{
    $i = 0;
    $k = mysql_num_rows($result);
        while ($row = mysql_fetch_array($result , MYSQL_ASSOC))
        {
                $d = new document($row['id'], $gen_body);
                $i++;

                if ((!empty($body_pattern))&&($gen_body))
                {
                        if (preg_match($body_pattern, $d->body, $match) > 0)
                        {
                                $d->body = $match[1];
                        }
                }

                $vars = array();
                foreach($d as $key_id => $key_value)
                {
                        if ($key_id != 'spec')
                        {
                                $vars['doc_'.$key_id] = $key_value;
                        }
                }

                $vars['doc_ord'] = $row['ord'];
                $vars['doc_link'] = $d->geturl();

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

                echo AssignVars($vars, $format);

                if (($separator)&&($i<$k))
                {
                    echo $separator;
                }
        }
}
else
{
        echo '������ MySQL: '.$sql.'<br>'.mysql_error();
}
?>
