<LINK href="../../style.css" rel="stylesheet" type="text/css">

<script src="../../menu.js"></script>

<script>
var selected_doc = -1;

function SetCode(doc_id)
{
        doc = GetDocInfo(doc_id);
        inp = document.getElementById('doccode');
        if (inp)
        {
                inp.value = doc[5];
        }

        if (doc_id != selected_doc)
        {
        	link = document.getElementById('doc_'+doc_id);
        	link.className = 'tree_selected';
        	link = document.getElementById('doc_'+selected_doc);
        	link.className = 'tree';
        	selected_doc = doc_id;
        }
}
<?
include '../../config.inc';
$sql="select * from engine_documents where code!=''";
$r=mysql_query ($sql);
echo "var count=".mysql_num_rows($r).";\n";
echo "var codes=new Array(".mysql_num_rows($r).");\n";
echo "var ids=new Array(".mysql_num_rows($r).");\n";
echo "var durl='/show.php?doc=';\n";
echo "var cardurl='/icproducts/';\n";

$k=0;
while ( $f = mysql_fetch_array($r)) {
        echo "ids[$k]=".$f[id].";\n";
         echo "codes[$k]='".strtolower($f[code])."';\n";
        $k++;
        }

?>
</script>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Ссылка (*ссылка на другую страницу, другой сервер или на якорь)</title>
<STYLE>
body, td, input {font-size: 9pt;font-family:Arial}
</STYLE>
</HEAD>
<body bgcolor="#D6D3CE">
<script language=javascript>
var myPlace = window.opener;

window.onerror = stopError

        function stopError() {
                return true;
        }

        function getLink() {

                if (myPlace.thePlace.selection.type == "Control") {
                        var oControlRange = myPlace.thePlace.selection.createRange();
                        if (oControlRange(0).tagName.toUpperCase() == "IMG") {
                                var oSel = oControlRange(0).parentNode;
                        }
                } else {
                        oSel = myPlace.thePlace.selection.createRange().parentElement();
                }

                if (oSel.tagName.toUpperCase() == "A")
                {
                        document.linkForm.targetWindow.value = oSel.target
                        document.linkForm.link.value = oSel.href
                        document.linkForm.originallink.value = oSel.href
                }else{
                 document.linkForm.link.value="http://"
                }
        }

        function InsertLink() {
                targetWindow = document.linkForm.targetWindow.value;
                var linkSource = document.linkForm.link.value;
                var linkCode = document.linkForm.code.value;
                var linkCardCode = document.linkForm.cardcode.value;
                if (linkSource=="http://") linkSource=""
                if (linkCardCode!="") {
                        linkSource=cardurl+""+linkCardCode+".html";
                		}
		    else if (linkCode!="") {
                        id=-1;
                        for (i=0;i<count;i++){
                                if (codes[i]==linkCode)
                                        id=ids[i];
                                }
                        if (id!=-1){
                                linkSource=durl+""+id;
                                }
                        else {
                                document.linkForm.code.value='';
                                alert('Документа с таким кодом не существует!');
                                return;
                                }
                        }

		    if (linkSource != "")
                {
                        var oNewLink = myPlace.thePlace.createElement("<A>");
                        oNewSelection = myPlace.thePlace.selection.createRange()

                        if (myPlace.thePlace.selection.type == "Control")
                        {
                                selectedImage = myPlace.thePlace.selection.createRange()(0);
                                selectedImage.width = selectedImage.width
                                selectedImage.height = selectedImage.height
                        }

                        oNewSelection.execCommand("CreateLink",false,linkSource);

                        if (myPlace.thePlace.selection.type == "Control")
                        {
                                oLink = oNewSelection(0).parentNode;
                        } else
                                oLink = oNewSelection.parentElement()

                        if (targetWindow != "")
                        {
                                oLink.target = targetWindow;
                        } else
                                oLink.removeAttribute("target")

                        window.close();
                } else {
                        alert("Ссылка не может быть пустой")
                        document.linkForm.link.focus()
                }
        }

        function CreateLink(LinkSource) {
                document.linkForm.link.value = LinkSource;
                document.linkForm.link.focus()
        }

        function RemoveLink() {
                if (myPlace.thePlace.selection.type == "Control")
                {
                        selectedImage = myPlace.thePlace.selection.createRange()(0);
                        selectedImage.width = selectedImage.width
                        selectedImage.height = selectedImage.height
                }

                myPlace.thePlace.execCommand("Unlink");
                window.close();
        }

        function getAnchors() {
                var allLinks = myPlace.thePlace.body.getElementsByTagName("A");
                for (a=0; a < allLinks.length; a++) {
                                if (allLinks[a].href.toUpperCase() == "") {
                                        document.write("<option value=#" + allLinks[a].name + ">" + allLinks[a].name + "</option>")
                                }
                }
        }

</script>
<FORM  name=linkForm >

<table style="border:1px solid white" border="0" cellspacing="0" cellpadding="2" width="100%">
<tr>
<td style="background-color:#fdfdfd;border:1px solid white" colspan=3>Свойства ссылки</td>
</tr>
<tr>
<td>Ссылка:</td>
<td><input type="text" name="link" value="" size="42"><input type="hidden" name="originallink" value=""></td>
<td><input type="button" style="width:110px" name="insertLink" value="Добавить" onClick="javascript:InsertLink();"></td>
</td>
</tr>
<tr>
<td valign="top">Код товара</td>
<td valign="top"><input type="text" name="cardcode" id=cardcode value="" size="42"></td>
<td>
</tr>
<tr>
<td valign="top">Код документа</td>
<td>
<input type="text" name="code" id=doccode value="" size="42"><br>
<style>
.line_blue
{
	border: 1px solid #053251;
	background-color: White;
}

a.tree
{
	color: Black;
	text-decoration: none;
}

.line_1_1
{
	background-image: url('img/line_1.gif');
	background-position: 16px 0px;
}

.tree_td
{
	padding-left: 3px;
}

a.tree_selected
{
	font-family: Arial, Helvetica, sans-serif;
	color: White;
	text-decoration: none;
	background-color: #3a769b;
}
</style>
<?
$http_link = 1;
include $engine_root.'/engine/link_tree.php';
echo $tree;
?>
</td>
<input type="hidden" size="15" name="targetWindow" value="">
</tr>
<tr>

<td>Где:</td>
<td>
<!-- <input type="text" size="15" name="targetWindow" value=""> -->
<select name="targetText" onChange="targetWindow.value = targetText[targetText.selectedIndex].value; targetText.value = ''; targetWindow.focus()">
<option value="">как есть</option>
<option value=_blank>новом окне</option>
<!-- <option value=_parent>родительском</option>
<option value=_self>в себе</option>
<option value=_top>выше фреймов</option>
 --></select>
</td>
<td><input type="button" style="width:110px" name="removeLink" value="Удалить" onClick="javascript:RemoveLink();"></td>
</tr>
<tr>
<td>Якорь:</td>
<td>
<select name="targetAnchor" onChange="link.value = link.value + targetAnchor[targetAnchor.selectedIndex].value; targetAnchor.value = ''; link.focus()">
<option value=""></option>
<script>getAnchors()</script>
</select></td>
<td><input type=button style="width:110px" name="Cancel" value="Отмена" onClick="javascript:window.close()"></td>
</tr>
</form>
<script>getLink()</script>
</table>
</body>
</html>