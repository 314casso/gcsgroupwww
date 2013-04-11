<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Hyperlink properties dialog
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2004-01-20
// ================================================

// include wysiwyg config
include '../config/spaw_control.config.php';
include $spaw_root.'class/util.class.php';
include $spaw_root.'class/lang.class.php';

$theme = SPAW_Util::getGETVar('theme',$spaw_default_theme);
$theme_path = $spaw_dir.'lib/themes/'.$theme.'/';

$l = new SPAW_Lang(SPAW_Util::getGETVar('lang'));
$l->setBlock('hyperlink');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
  <title><?php echo $l->m('title')?></title>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_path.'css/'?>dialog.css">
  <?php if (SPAW_Util::getBrowser() == 'Gecko') { ?>
  <script language="javascript" src="utils.gecko.js"></script>
  <?php }else{ ?>
  <script language="javascript" src="utils.js"></script>
  <?php } ?>

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

.docs_tree tr,
.docs_tree td,
.docs_tree table,
.doc_tree a
{	font-family: Arial, Helvetica, sans-serif;
	margin : 0;
	font-size: 8pt;
}
</style>

  <script language="javascript">
  <!--
  function Init() {
    var aProps = window.dialogArguments;
    if (aProps && (aProps.href || aProps.name))
    {
      // set attribute values
      if (aProps.href) {
        document.getElementById("chref").value = aProps.href;
      }
      if (aProps.name) {
        document.getElementById("cname").value = aProps.name;
      }

      setTarget(aProps.target);

      if (aProps.title) {
        document.getElementById("ctitle").value = aProps.title;
      }
    }
    var found = setAnchors(aProps.anchors, aProps.href);
   // setAnchors_link(aProps.anchors, aProps.href);


    var atype = "link";
    if (aProps.name)
    {
      atype = "anchor";
    }
    else if (found)
    {
      atype = "link2anchor";
    }
    if (document.getElementById("canchor").options.length<=1)
    {
      // no anchors found, disable link to anchor feature
      document.getElementById("catype").remove(3);
    }
    changeType(atype);
  }

  function validateParams()
  {
    return true;
  }

  function okClick() {
    // validate paramters
    if (validateParams())
    {
      var aProps = {};
      if (document.getElementById("catype").options[document.getElementById("catype").selectedIndex].value == "link2anchor")
        aProps.href = (document.getElementById("canchor").options[document.getElementById("canchor").selectedIndex].value)?(document.getElementById("canchor").options[document.getElementById("canchor").selectedIndex].value):'';
      else if (document.getElementById("catype").options[document.getElementById("catype").selectedIndex].value == "linkengine"){
	//aProps.href_ = (document.getElementById("canchor_link").options[document.getElementById("canchor_link").selectedIndex].value)?(document.getElementById("canchor_link").options[document.getElementById("canchor_link").selectedIndex].value):'';
	aProps.href_ = (document.getElementById("canchor_link_input").value)?(document.getElementById("canchor_link_input").value):'';
	if (aProps.href_ != ''){
	        aProps.href = GetEngineLink() + '#' + aProps.href_;
	}
	else{
	        aProps.href = GetEngineLink();
	}
		//alert(aProps.href_);
      }
      else
        aProps.href = (document.getElementById("chref").value)?(document.getElementById("chref").value):'';

      aProps.name = (document.getElementById("cname").value)?(document.getElementById("cname").value):'';
      aProps.target = (document.getElementById("ctarget").value)?(document.getElementById("ctarget").value):'';
      aProps.title = (document.getElementById("ctitle").value)?(document.getElementById("ctitle").value):'';

      window.returnValue = aProps;
      window.close();
      <?php
      if (!empty($_GET['callback']))
        echo "opener.".$_GET['callback']."('".$_GET['editor']."',this);\n";
      ?>
    }
  }

  function cancelClick() {
    window.close();
  }


  function setTarget(target)
  {
    for (i=0; i<document.getElementById("ctarget").options.length; i++)
    {
      tg = document.getElementById("ctarget").options.item(i);
      if (tg.value == target.toLowerCase()) {
        document.getElementById("ctarget").selectedIndex = tg.index;
      }
    }
  }

  function setAnchors(anchors, anchor)
  {
  	var found = false;
  	for(var i=0; i < anchors.length; i++)
    {
      var opt = document.createElement("OPTION");
      document.getElementById("canchor").options.add(opt);
     // document.getElementById("canchor_link1").options.add(opt);
      opt.innerText = anchors[i];
      opt.value = '#'+anchors[i];
      if (opt.value == anchor)
      {
        opt.selected = true;
        found = true;
      }
    }
    return found;
  }

  function setAnchors_link(anchors, anchor)
  {
  	var found = false;
  	for(var i=0; i<anchors.length; i++){
		//alert ('--'+anchors[i]);
      		var opt = document.createElement("OPTION");
	   	document.getElementById("canchor_link").options.add(opt);
      		opt.innerText = anchors[i];
      		opt.value = '#'+anchors[i];
     		if (opt.value == anchor){
        		opt.selected = true;
       		found = true;
      		}
    	}
    	return found;
  }

  function changeType(new_type)
  {
    document.getElementById("catype").selectedIndex = 0;
    if (new_type == "anchor")
    {
      document.getElementById("catype").selectedIndex = 1;
    }
    else if (new_type == "linkengine")
    {
      document.getElementById("catype").selectedIndex = 2;
    }
    else if (new_type == "link2anchor")
    {
      document.getElementById("catype").selectedIndex = 3;
    }

    document.getElementById("url_row").style.display = new_type=="link"?"":"none";
    document.getElementById("engine_row").style.display = new_type=="linkengine" ? "" : "none";
    document.getElementById("engine_row_link").style.display = new_type=="linkengine" ? "" : "none";
    document.getElementById("name_row").style.display = new_type=="anchor"?"":"none";
    document.getElementById("anchor_row").style.display = new_type=="link2anchor"?"":"none";
    document.getElementById("target_row").style.display = (new_type=="link"||new_type=="link2anchor"||new_type=="linkengine")?"":"none";

    resizeDialogToContent();
  }

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

  function GetEngineLink()
  {  	result = '';
  	if (selected_doc > 0)
        {
                var k = 0;
                var doc = GetDocInfo(selected_doc);

                while ((doc[1] != -1)&&(k<15))
                {                        result = '/' + doc[5] + result;
                        doc = GetDocInfo(doc[1]);
                        k++;
                }

                result = '/cntnt/' + doc[5] + result + '.html';
        }

        return result;
  }
  //-->
  </script>
</head>

<body onLoad="Init()" dir="<?php echo $l->getDir();?>">
<table border="0" cellspacing="0" cellpadding="2" width="336">
<form name="a_prop">
<tr>
  <td width="50%"><?php echo $l->m('a_type')?>:</td>
  <td width="50%">
  <select name="catype" id="catype" size="1" class="input" onchange="changeType(this.options[this.selectedIndex].value);">
  	<option value="link"><?php echo $l->m('type_link')?></option>
  	<option value="anchor"><?php echo $l->m('type_anchor')?></option>
  	<option value="linkengine"><?php echo $l->m('type_linkengine')?></option>
  	<option value="link2anchor"><?php echo $l->m('type_link2anchor')?></option>
  </select>
  </td>
</tr>
<tr id="url_row">
  <td width="50%"><?php echo $l->m('url')?>:</td>
  <td width="50%"><input type="text" name="chref" id="chref" class="input" size="32"></td>
</tr>
<tr id="name_row">
  <td width="50%"><?php echo $l->m('name')?>:</td>
  <td width="50%"><input type="text" name="cname" id="cname" class="input" size="32"></td>
</tr>
<tr id="anchor_row">
  <td width="50%"><?php echo $l->m('anchors')?>:</td>
  <td width="50%">
  <select name="canchor" id="canchor" size="1" class="input">
  	<option></option>
  </select>
  </td>
</tr>
<tr id="engine_row_link">
  <td width="50%"><?php echo $l->m('anchors')?>:</td>
  <td width="50%">
  <!--<select name="canchor_link" id="canchor_link" size="1" class="input">
  	<option></option>
  </select>-->
  <input name="canchor_link_input" size="7" class="input">
  </td>
</tr>
<tr id="engine_row">
  <td valign="top">Документ</td>
  <td class="docs_tree">
  <?
  include '../../config.inc';
  include $engine_root.'/engine/link_tree.php';
  echo $tree;
  ?>
  </td>
</tr>




<tr id="target_row">
  <td width="50%"><?php echo $l->m('target')?>:</td>
  <td width="50%" align="left">
  <select name="ctarget" id="ctarget" size="1" class="input">
    <?php
		foreach($spaw_a_targets as $key=>$value)
		{
			if ($l->m($key,'hyperlink_targets')!='')
				$value = $l->m($key,'hyperlink_targets');
			echo '<option value="'.$key.'">'.$value."</option>";
		}
	?>
  </select>
  </td>
</tr>
<tr id="title_row">
  <td width="50%"><?php echo $l->m('title_attr')?>:</td>
  <td width="50%" align="left">
    <input type="text" name="ctitle" id="ctitle" size="32" class="input">
  </td>
</tr>
<tr>
<td colspan="2" nowrap>
<hr width="100%">
</td>
</tr>
<tr>
<td colspan="2" align="right" valign="bottom" nowrap>
<input type="button" value="<?php echo $l->m('ok')?>" onClick="okClick()" class="bt">
<input type="button" value="<?php echo $l->m('cancel')?>" onClick="cancelClick()" class="bt">
</td>
</tr>
</form>
</table>

</body>
</html>
