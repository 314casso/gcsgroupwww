<?

global $engine_show_htroot;

$d=$doc;


$splitter = trim ($splitter);

if (!$splitter)

        $splitter='/';
        
$root = trim ($root);

if (!$root)

        $root="Главная";

if (!$format)

        $format="<a class=path href='ITEM_LINK'>ITEM_TEXT</a>";



while ($d->id!=-1){

        if ($logged)

                $sql="select * from engine_documents where id='{$d->id}' and visible=1 order by ord,name ";

        else

                $sql="select * from engine_documents where id='{$d->id}' and visible=1 and !private order by ord,name ";



        $sql="select * from engine_documents where id='{$d->id}'";

        $r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

        $f=mysql_fetch_array($r);



        $showit=1;

        if ($f[type]=='FOLDER'){

            $sql="select notinpath from engine_FOLDER where doc_id='{$d->id}'";

            $r1=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

            $f1=mysql_fetch_array($r1);



            if ($f1[notinpath])

            	$showit=0;

     		}

     	  if ($showit){

            if ($f[visible]){



                    $a[$i++]=str_replace('ITEM_TEXT',$f[name],str_replace('ITEM_LINK',geturl($f[id]),$format));

                    }

            else

                    $a[$i++]=$f[name];

            }

        $d=new Document($d->pid);

        }

echo str_replace('ITEM_TEXT', $root, str_replace ('ITEM_LINK', "/", $format)).$splitter;

for ($m=$i-1;$m>=1;$m--){

        echo $a[$m].$splitter;

        }

echo $a[$m];







?>