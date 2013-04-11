<?

        $sql="select * from  engine_NEWSGROUP where doc_id=$id";

        $r=mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

        if (mysql_num_rows($r)==0) {

                $sql="insert into  engine_NEWSGROUP(format,ncount,doc_id) values('$format','$ncount',$id)";

                mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

                }

        else {

                $sql="update engine_NEWSGROUP set ncount='$ncount',format='$format' where doc_id=$id";

                mysql_query($sql) or die("SQL error ".mysql_error()." in: $sql\n");

                }



?>