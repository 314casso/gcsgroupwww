isDOM=document.getElementById //DOM1 browser (MSIE 5+, Netscape 6, Opera 5+)

isNetscape4=document.layers //Netscape 4.*
isOpera=navigator.userAgent.indexOf("Opera")>=0 //Opera

isOpera7=(navigator.userAgent.indexOf("Opera 7")>=0) || (navigator.userAgent.indexOf("Opera/7")>=0);
isOpera5=isOpera && isDOM && !isOpera7 //Opera 5+

isMSIE=document.all && document.all.item && !isOpera //Microsoft Internet Explorer 4+

isMSIE5=isDOM && isMSIE && !isOpera //MSIE 5+

isMozilla=isNetscape6=isDOM && !isMSIE && !isOpera //Mozilla или Netscape 6.*

img1=new Image()
img1.src="check.gif"
img2=new Image()
img2.src="check.gif"

var controlsNum = 0;
var objId  = new Array();
var dPath = new Array();
var objParam = new Array();
var ctlMode = new Array();
var formfieldName = new Array();
var editSource = ['Y','N'];
var colorType='BackColor';
var colorSet = [
'#FF0000','#FFFF00','#00FF00','#00FFFF','#0000FF','#FF00FF','#FFFFFF','#F5F5F5','#DCDCDC','#FFFAFA',
'#D3D3D3','#C0C0C0','#A9A9A9','#808080','#696969','#000000','#2F4F4F','#708090','#778899','#4682B4',
'#4169E1','#6495ED','#B0C4DE','#7B68EE','#6A5ACD','#483D8B','#191970','#000080','#00008B','#0000CD',
'#1E90FF','#00BFFF','#87CEFA','#87CEEB','#ADD8E6','#B0E0E6','#F0FFFF','#E0FFFF','#AFEEEE','#00CED1',
'#5F9EA0','#48D1CC','#00FFFF','#40E0D0','#20B2AA','#008B8B','#008080','#7FFFD4','#66CDAA','#8FBC8F',
'#3CB371','#2E8B57','#006400','#008000','#228B22','#32CD32','#00FF00','#7FFF00','#7CFC00','#ADFF2F',
'#98FB98','#90EE90','#00FF7F','#00FA9A','#556B2F','#6B8E23','#808000','#BDB76B','#B8860B','#DAA520',
'#FFD700','#F0E68C','#EEE8AA','#FFEBCD','#FFE4B5','#F5DEB3','#FFDEAD','#DEB887','#D2B48C','#BC8F8F',
'#A0522D','#8B4513','#D2691E','#CD853F','#F4A460','#8B0000','#800000','#A52A2A','#B22222','#CD5C5C',
'#F08080','#FA8072','#E9967A','#FFA07A','#FF7F50','#FF6347','#FF8C00','#FFA500','#FF4500','#DC143C',
'#FF0000','#FF1493','#FF00FF','#FF69B4','#FFB6C1','#FFC0CB','#DB7093','#C71585','#800080','#8B008B',
'#9370DB','#8A2BE2','#4B0082','#9400D3','#9932CC','#BA55D3','#DA70D6','#EE82EE','#DDA0DD','#D8BFD8',
'#E6E6FA','#F8F8FF','#F0F8FF','#F5FFFA','#F0FFF0','#FAFAD2','#FFFACD','#FFF8DC','#FFFFE0','#FFFFF0',
'#FFFAF0','#FAF0E6','#FDF5E6','#FAEBD7','#FFE4C4','#FFDAB9','#FFEFD5','#FFF5EE','#FFF0F5','#FFE4E1'];

function selOn(ctrl) { ctrl.style.borderColor = '#546697';
  ctrl.style.backgroundColor = '#B5BED6';
  ctrl.style.cursor = 'hand'; }

function selOff(ctrl) { ctrl.style.borderColor = '#76C5F0';
  ctrl.style.backgroundColor = '#76C5F0'; }

function sellOff(ctrl) { ctrl.style.borderColor = '#546697';
ctrl.style.backgroundColor = '#76C5F0'; }

function selDown(ctrl) { ctrl.style.backgroundColor = '#8492B5';  }

function selUp(ctrl) { ctrl.style.backgroundColor = '#B5BED6';  }

function isWhatSelected(ctrlId,what) {
 iView=eval("iViewN"+ctrlId);
 if (iView.document.selection.type == "Control") {
  var oControlRange = iView.document.selection.createRange();
  if (oControlRange(0).tagName.toUpperCase() == what) {
   eval('selected'+what+'= iView.document.selection.createRange()(0)');
   return true;
  }
 }
}

function isCursorInTableCell(ctrlId) {
 iView=eval("iViewN"+ctrlId);
 if (iView.document.selection.type != "Control") {
  var elem = iView.document.selection.createRange().parentElement()
  while (elem.tagName.toUpperCase() != "TD" && elem.tagName.toUpperCase() != "TH")
  {
    elem = elem.parentElement
    if (elem == null)
     break
  }
  if (elem) {
   selectedTD = elem
   selectedTR = selectedTD.parentElement
   selectedTBODY =  selectedTR.parentElement
   selectedTABLE = selectedTBODY.parentElement
   return true
  }
 }
}

function findParentTable(cell) {
 var tbl = cell.parentElement
 while (tbl) {
  if (tbl.tagName == "TABLE") return tbl;
  tbl = tbl.parentElement;
 }
 return false;
}


function addOrRemoveCols(tbl, cellidx, action) {
 if (!tbl.childNodes.length) return;
 for (i = 0; i < tbl.childNodes.length; i++) {
  if (tbl.childNodes[i].tagName == "TR") {
   var cell = tbl.childNodes[i].childNodes[ cellidx ];
   if (!cell)
    break; // can't add cell after cell that doesn't exist
   if (action == "add") {
    cell.insertAdjacentElement("AfterEnd",  document.createElement("TD") );
   } else {
    // don't delete too many cells because or a rowspan setting
    if (cell.rowSpan > 1)
     i += (cell.rowSpan - 1);
    cell.removeNode(true);
   }
  } else {
   // keep looking for a "TR"
   addOrRemoveCols(tbl.childNodes[i], cellidx, action);
  }
 }
}

function processRow(action) {
 if (!tableCell)
  return;
 var idx = 0;
 var rowidx = -1;
 var tr = tableCell.parentNode;
 var numcells = tr.childNodes.length;
 while (tr) {
  if (tr.tagName == "TR")
    rowidx++;
  tr = tr.previousSibling;
 }
 var tbl = findParentTable(tableCell);
 if (!tbl) {
  alert("Could not " + action + " row.");
  return;
 }
 if (action == "add") {
  var r = tbl.insertRow(rowidx);
  for (var i = 0; i < numcells; i++) {
   var td = document.createElement("TD");
   c = r.insertAdjacentElement("afterBegin",  document.createElement("TD") );

   if (tableCell.parentNode.childNodes[i].colSpan)
    c.colSpan = tableCell.parentNode.childNodes[i].colSpan;
  }
 } else {
    tbl.deleteRow(rowidx);
 }
}


function processColumn(action) {
 if (!tableCell)
  return;
 var cellidx = tableCell.cellIndex;
 var tbl = findParentTable(tableCell);
 if (!tbl) {
  alert("Could not " + action + " column.");
  return;
 }
 addOrRemoveCols(tbl, cellidx, action);
}

function mergeRight() {
 if (!tableCell)
  return;
 if (!tableCell.nextSibling)
  return;

 // don't allow user to merge rows with different rowspans
 if (tableCell.rowSpan != tableCell.nextSibling.rowSpan) {
  alert("Can't merge cells with different rowSpans.");
  return;
 }

 tableCell.innerHTML += tableCell.nextSibling.innerHTML;
 tableCell.colSpan += tableCell.nextSibling.colSpan;
 tableCell.nextSibling.removeNode(true);
}

function mergeDown() {
 if (!tableCell)
  return;
 if (!tableCell.parentNode.nextSibling) {
  alert("There is not a cell below this one to merge with.");
  return;
 }
 var topRowIndex = tableCell.parentNode.rowIndex;
 var bottomCell = tableCell.parentNode.parentNode.childNodes[ topRowIndex + tableCell.rowSpan ].childNodes[ tableCell.cellIndex ];
 if (!bottomCell) {
  alert("There is not a cell below this one to merge with.");
  return;
 }
 if (tableCell.colSpan != bottomCell.colSpan) {
  alert("Can't merge cells with different colSpans.");
  return;
 }
 tableCell.innerHTML += bottomCell.innerHTML;
 tableCell.rowSpan += bottomCell.rowSpan;
 bottomCell.removeNode(true);
}

function addCell() {
 if (!tableCell)
  return;

 tableCell.parentElement.insertAdjacentElement("afterBegin",  document.createElement("TD") );
}

function removeCell() {
 if (!tableCell)
  return;
 if (!tableCell.previousSibling && !tableCell.nextSibling) {
  alert("You can't remove the only remaining cell in a row.");
  return;
 }
 tableCell.removeNode(false);
}

function SetTableCell(ctrlId){
 tableCell=null;
 var sel = eval("iViewN"+ctrlId).document.selection.createRange();
 var elt = sel.parentElement();
 while (elt) {
  if (elt.tagName == "TD")
    break;
  elt = elt.parentElement;
 }
 tableCell=elt;
}

function doCleanCode(code) {
 // removes all empty <p> tags
 code = code.replace(/<p([^>])*>(&nbsp;)*\s*<\/p>/gi,"")
 // removes all empty span tags
 code = code.replace(/<span([^>])*>(&nbsp;)*\s*<\/span>/gi,"")

/*
 RemTags = ['font','SPAN','DIV','o:p'];
 for(a=0; a < RemTags.length; a++)
  { T = RemTags[a];
    RemTagsRgx= new RegExp("<"+T+" .*((\")|(')|(left)|( )|([0-9]))>|<"+T+" .*\\n.*((\")|(')|(left)|( )|([0-9]))>|<"+T+">|<"+T+".*\\n>|<\\/"+T+">","gi");
    code = code.replace(RemTagsRgx, "");
  }
 code=code.replace(/class=\"\"/g,"");
*/

 // removes all Class attributes on a tag eg. '<p class=asdasd>xxx</p>' returns '<p>xxx</p>'
 code = code.replace(/<([\w]+) class=([^ |>]*)([^>]*)/gi, "<$1$3")
 // removes all style attributes eg. '<tag style="asd asdfa aasdfasdf" something else>' returns '<tag something else>'
 code = code.replace(/<([\w]+) style="([^"]*)"([^>]*)/gi, "<$1$3")
 // gets rid of all xml stuff... <xml>,<\xml>,< ?xml> or <\?xml>
 code = code.replace(/<\\?\??xml[^>]>/gi, "")
 // get rid of ugly colon tags <a:b> or </a:b>
 code = code.replace(/<\/?\w+:[^>]*>/gi, "")
 // get rid of silly space tags
 code = code.replace(/&nbsp;/gim, "")
 return code
}

function cleanCode(ctrlId) {
 iView = eval("iViewN"+ctrlId).document;

 var selectedArea = iView.selection.createRange()
 tx=selectedArea.htmlText;

 if (tx!='') {
  selectedArea.pasteHTML(doCleanCode(tx))
 }
 else{
  if (confirm("Вы точно хотите отчистить текст от лишнего форматирования?"))
   iView.body.innerHTML=doCleanCode(iView.body.innerHTML);
 }
}

function doCmd(ctrlId,cmd){

 if (cmd.indexOf("|") >= 0){
  param = cmd.split("|");
  cmd=param[0];
  param=param[1];
 } else {
  param=null;
 }

 if (ctlMode[ctrlId]==1){
  iView = eval("iViewN"+ctrlId);

  if (isCursorInTableCell(ctrlId)) {
   switch( cmd ) {
     case 'modifycell':
     dlg=dPath[ctrlId]+"/dialogs/mcell.htm";
     window.open(dlg,'',"resizable=yes,height=130,width=395,status=yes,toolbar=no,menubar=no,location=no");
     return;
     break;
    case 'insertrow':
     SetTableCell(ctrlId);
     processRow("add");
     return;
     break;
    case 'removerow':
     SetTableCell(ctrlId);
     processRow("remove");
     return;
    case 'insertcol':
     SetTableCell(ctrlId);
     processColumn("add");
     return;
    case 'removecol':
     SetTableCell(ctrlId);
     processColumn("remove");
     return;
    case 'mergecellright':
     SetTableCell(ctrlId);
     mergeRight();
     return;
    case 'mergecelldown':
     SetTableCell(ctrlId);
     mergeDown();
     return;
    case 'insertcell':
     SetTableCell(ctrlId);
     addCell();
     return;
    case 'removecell':
     SetTableCell(ctrlId);
     removeCell();
     return;
   }
  }

  if ( (cmd=='createtable' && isWhatSelected(ctrlId,'TABLE')) ||
       (cmd=='modifytable' && (isWhatSelected(ctrlId,'TABLE') || isCursorInTableCell(ctrlId)) ) ) {
     dlg=dPath[ctrlId]+"/dialogs/mtable.htm";
     window.open(dlg,'',"resizable=yes,height=140,width=440,status=yes,toolbar=no,menubar=no,location=no");
     return;
  }

  if (eval("iViewN"+ctrlId).document.selection.type == 'Control')
    return;

  switch( cmd ) {
   case 'createtable':
    thePlace=eval("iViewN"+ctrlId).document.selection.createRange();
    dlg=dPath[ctrlId]+"/dialogs/table.htm";
    window.open(dlg,'',"resizable=yes,height=220,width=350,status=yes,toolbar=no,menubar=no,location=no");
    return;
   case 'clearcode':
    cleanCode(ctrlId);
    return;
   case 'createlink':
    thePlace=eval("iViewN"+ctrlId).document;
    dlg=dPath[ctrlId]+"/dialogs/link.php";
    // GetParam = showModalDialog(dPath, null, "font-family:Verdana; font-size:8pt; resizable:no; scroll:no;status:no; dialogWidth:445px; dialogHeight:135px");
    window.open(dlg,'',"resizable=yes,height=500,width=440,status=yes,toolbar=no,menubar=no,location=no");
    return;
   case 'createanchor':
    thePlace=eval("iViewN"+ctrlId).document;
    dlg=dPath[ctrlId]+"/dialogs/anchor.htm";
    // GetParam = showModalDialog(dPath, null, "font-family:Verdana; font-size:8pt; resizable:no; scroll:no;status:no; dialogWidth:330px; dialogHeight:95px;");
    window.open(dlg,'',"resizable=yes,height=100,width=335,status=yes,toolbar=no,menubar=no,location=no");
    return;
    break
  }
 } else {
  iView = document.all["iViewY"+ctrlId];
 }

 var mode=false;

 // if (cmd=='createlink') mode=true;

 if (editSource[ctlMode[ctrlId]]=='N'){
  //eval("iView"+editSource[ctlMode[ctrlId]]+ctrlId).document.body.focus();
  eval("iView"+editSource[ctlMode[ctrlId]]+ctrlId).document.execCommand(cmd, mode, param);
  // document.execCommand(cmd,mode,null);
 } else {
  cmdList=new Array();
  cmdList=[
['bold','<b></b>'],['italic','<i></i>'],['underline','<u></u>'],
['strikethrough','<strike></strike>'],['justifyleft','<P align="left"></P>'],
['justifyright','<P align="right"></P>'],
['justifycenter','<P align="center"></P>'],
['justifyfull','<P align="justify"></P>'],
['insertorderedlist',"<OL>\n\r <LI> </LI>\n\r<LI> </LI>\n\r</OL>"],
['insertunorderedlist',"<UL>\n\r <LI> </LI>\n\r<LI> </LI>\n\r</UL>"],
['inserthorizontalrule','<hr>'],
['createanchor',"void(q=prompt('Enter the Anchor name:',''));if (q) ret='<A name=\"'+q+'\">'+'</A>'",'1'],
['createlink',"void(q=prompt('Enter the URL (http://, ftp://, mailto:) :','http://'));if (q) ret='<A href=\"http://'+q+'\">'+q+'</A>'",'1'],
['insertcell','<td></td>']];

  iView.focus();
  for (var i = 0; i < cmdList.length; i++) {
   if (cmdList[i][0] == cmd) {
    if (cmdList[i][2]) {
     ret='';
     eval(cmdList[i][1]);
     iView.value+=ret;
    } else {
     iView.value+=cmdList[i][1];
    }
    return;
   }
  }
 }
}

function insImage(ctrlId,img){
 if (img=='') return false;
 eval("iView"+editSource[ctlMode[ctrlId]]+ctrlId).document.body.focus()
 // eval("iView"+editSource[ctlMode[ctrlId]]+ctrlId).document.execCommand('insertimage', 1, img)
 eval("iView"+editSource[ctlMode[ctrlId]]+ctrlId).document.execCommand('insertimage', 0, img)
}

function doImage(ctrlId) {
 if (ctlMode[ctrlId]==1) {
   if (isWhatSelected(ctrlId,'IMG')) {
   dlg=dPath[ctrlId]+"/dialogs/mimage.htm";
   window.open(dlg,"","resizable=yes,height=250,width=435,status=yes,toolbar=no,menubar=no,location=no");
  } else {
   dlg=dPath[ctrlId]+"/dialogs/image.php?obj_id=" + objId[ctrlId]+"&ctrlId="+ctrlId;
   window.open(dlg,"","scrollbars=yes,height=525,width=470,help=no,status=no");
  }
 }
}

/*
function doImage(ctrlId)
{
 var param2win='';
 var r = eval("iViewN"+ctrlId).document.selection.createRange();
 if (eval("iViewN"+ctrlId).document.selection.type != 'Text') {
  if (r.length == 1) {
   if (r.item(0).tagName == "IMG") {
    var selectedImage = r.item(0);
    param2win='&url='+selectedImage.src;
   }
  }
 }

 iarr = new Array();
 dlg=dPath[ctrlId]+"/dialogs/image.php?obj_id=" + objId[ctrlId]+"&ctrlId="+ctrlId+param2win;
 window.open(dlg,'',"resizable=yes,height=350,width=450,status=yes,toolbar=no,menubar=no,location=no");
}
*/

function exportHtml(){
 fname = event.srcElement.name;

 for(i=1; i < formfieldName.length; i++){
  FormName = formfieldName[i][0];
  FieldName = formfieldName[i][1];
  OldTextArea = eval("document."+FormName+"."+FieldName);

  if (FormName==fname){
   if (isOpera7){
     CurrentText = document.all["iViewY"+i].value;
   } else {
    if (document.all["iViewY"+i].style.display == "block"){
     CurrentText = document.all["iViewY"+i].value;
    }else{
     CurrentText = eval("iViewN"+i).document.body.innerHTML;
    }
   }
   OldTextArea.value = CurrentText;
  }
 }
}

function setMode(ctrlId,mode) {
 iView = eval("iViewN"+ctrlId);
 icView = document.all["iViewN"+ctrlId];
 tView = document.all["iViewY"+ctrlId];
 if(mode){
  iView.document.body.innerHTML = tView.value;
  icView.style.display = 'block';
  tView.style.display = 'none';
  ctlMode[ctrlId] = 1;
  eval("iViewN"+ctrlId).document.body.focus()
 }else{
  tView.value = iView.document.body.innerHTML;
  icView.style.display = 'none';
  tView.style.display = 'block';
  tView.focus();
  ctlMode[ctrlId] = 0;
 }
}

function doMaxMin(ctrlId,el){
 // some useful offset`s
 var wofs = 55;
 var hofs = 140;
 par=eval("WEditorTable"+ctrlId).offsetParent;
 topX=par.offsetTop-5;
 while (par.offsetTop){
  topX+=par.offsetTop;
  par=par.offsetParent;
 }
// var w=top.document.body.offsetWidth-wofs
 var w=805-wofs
 var h=top.document.body.offsetHeight-hofs

 if ((eval("WEditorTable"+ctrlId).offsetWidth!=w) || (eval("WEditorTable"+ctrlId).offsetHeight!=h)){

  objParam[ctrlId]=new Array();
  objParam[ctrlId][0]=eval("WEditorTable"+ctrlId).offsetWidth;
  objParam[ctrlId][1]=eval("WEditorTable"+ctrlId).offsetHeight;
  el.src = el.src.replace('max\.gif', 'min\.gif');
  eval("WEditorTable"+ctrlId).width=w;
  eval("WEditorTable"+ctrlId).height=h;

 }else{
  el.src = el.src.replace('min\.gif', 'max\.gif');
  eval("WEditorTable"+ctrlId).width=objParam[ctrlId][0];
  eval("WEditorTable"+ctrlId).height=objParam[ctrlId][1];
 }
 scrollTo(1, topX);
}

function hideColor(ctrlId){
 eval('colorMenu'+ctrlId).style.visibility='hidden';
}

function insColor(ctrlId,oColor) {
 eval("iViewN"+ctrlId).document.execCommand(colorType,false,oColor);
}

function CreateEditor(FormName , FieldName, obj_id, dlgpath, wheight, short){
 if (!wheight) wheight='200';
 controlsNum++;
 objId[controlsNum] = obj_id;
 dPath[controlsNum] = dlgpath;
 formfieldName[controlsNum] = new Array(FormName, FieldName);
 htmm='<style>.butClass { border:1px solid #76C5F0;width:20px;height:20px }.input{ height:20px;font-size:8pt;border:1px solid #76C5F0;background-color:#76C5F0}.txtClass { border:1px solid #76C5F0;background-color:#76C5F0 }.downClass { border:1px solid #76C5F0;width:9px;height:20px }</style>'+
'<table  onDrag="return false;" id="WEditorTable'+controlsNum+'" border="0" cellpadding="0" cellspacing="0" style="margin: 1; margin-left: -1; " height="100%" width="100%">'+
'<tr ><td style="padding-left: 3px; padding-top:3px;" bgcolor="#76C5F0" height="30">'+

'<img name="undo" alt="Вернуть" class="butClass" src="'+dlgpath+'/img/undo.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +
'<img name="redo" alt="Повторить" class="butClass" src="'+dlgpath+'/img/redo.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +

'<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">'+

'<img name="cut" alt="Вырезать (Ctrl-X)" class="butClass" src="'+dlgpath+'/img/cut.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +
'<img name="copy" alt="Скопировать (Ctrl-C)" class="butClass" src="'+dlgpath+'/img/copy.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +
'<img name="paste" alt="Вставить (Ctrl-V)" class="butClass" src="'+dlgpath+'/img/paste.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +

'<img border=0 wisth=2 src="'+dlgpath+'/img/rul.gif">'+
'<img name="bold" alt="Bold" class="butClass" src="'+dlgpath+'/img/bold.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">';

if (short) htmm+='<div id="weightmenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onClick="this.style.visibility=\'hidden\'" onmouseover="this.style.visibility=\'visible\'" onmouseout="this.style.visibility=\'hidden\'">';

htmm+='<img name="italic" alt="Наклон" class="butClass" src="'+dlgpath+'/img/italic.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="underline" alt="Подчерк" class="butClass" src="'+dlgpath+'/img/underline.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">';

if (!short) htmm+='<div id="weightmenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onClick="this.style.visibility=\'hidden\'" onmouseover="this.style.visibility=\'visible\'" onmouseout="this.style.visibility=\'hidden\'">';

htmm+='<img name="strikethrough" alt="Зачеркивание" class="butClass" src="'+dlgpath+'/img/strike.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">' +
'<img name="superscript" alt="Верзний индекс" class="butClass" src="'+dlgpath+'/img/sup.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="subscript" alt="Нижний индекс" class="butClass" src="'+dlgpath+'/img/sub.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="removeformat" alt="Убрать форматирование" class="butClass" src="'+dlgpath+'/img/clear.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<br>'+
'</div>'+
'<img class="downClass" src="'+dlgpath+'/img/dn.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="weightmenu'+controlsNum+'.style.visibility=\'visible\';eval(\'iView\'+editSource[ctlMode['+controlsNum+']]+'+controlsNum+').document.body.focus();">' +

'<!--<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">'+

'<img name="fontcolor" alt="Цвет текста" class="butClass" src="'+dlgpath+'/img/fontcolor.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="colorType=\'ForeColor\';colorMenu'+controlsNum+'.style.marginLeft=\'-20px\';colorMenu'+controlsNum+'.style.visibility=\'visible\'"> ' +
'<div onClick="hideColor('+controlsNum+')" align="center" ID="colorMenu'+controlsNum+'" onmouseover="this.style.visibility=\'visible\'" onmouseout="this.style.visibility=\'hidden\'" STYLE="background-color:#76C5F0;margin-left:0px;margin-top:20px;border:1px solid black;position:absolute;visibility:hidden">';
 for (s=0;s<colorSet.length;s++){
 htmm+='<img src="'+dlgpath+'/img/no.gif" width="9" style="background-color:'+colorSet[s]+';" onClick="insColor('+controlsNum+',\''+colorSet[s]+'\')">';
  if ((s+1)/20==parseInt((s+1)/20)) htmm+='<br>';
 }
 htmm+=''+
'<input onMouseOver="selOn(this)" onMouseOut="selOff(this)" class="input" type="button" onClick="hideColor('+controlsNum+');void(q=prompt(\'Введите название или значение цвета:\',\'\'));if (q) { insColor('+controlsNum+',q) };" value="ввести">'+
'<input onMouseOver="selOn(this)" onMouseOut="selOff(this)" class="input" type="button" onClick="insColor('+controlsNum+',\'\');hideColor('+controlsNum+')" value="отчистить">'+
'</div>'+
'<img name="forecolor" alt="Цвет фона" class="butClass" src="'+dlgpath+'/img/bgcolor.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="colorType=\'BackColor\';colorMenu'+controlsNum+'.style.marginLeft=\'0px\';colorMenu'+controlsNum+'.style.visibility=\'visible\'">-->' +

'<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">'+

'<img name="justifyleft" alt="Выровнять влево" class="butClass" src="'+dlgpath+'/img/left.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">';

if (short) htmm+='<div id="justifymenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onmouseover="this.style.visibility=\'visible\'" onClick="this.style.visibility=\'hidden\'" onmouseout="this.style.visibility=\'hidden\'">';

htmm+='<img name="justifycenter" alt="Выровнять по центру" class="butClass" src="'+dlgpath+'/img/center.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="justifyright" alt="Выровнять вправо" class="butClass" src="'+dlgpath+'/img/right.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">';

if (!short) htmm+='<div id="justifymenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onmouseover="this.style.visibility=\'visible\'" onClick="this.style.visibility=\'hidden\'" onmouseout="this.style.visibility=\'hidden\'">';

htmm+='<img name="justifyfull" alt="Выровнять по ширине" class="butClass" src="'+dlgpath+'/img/justify.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="indent" alt="Увеличить отступ" class="butClass" src="'+dlgpath+'/img/indent.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="outdent" alt="Уменьшить отступ" class="butClass" src="'+dlgpath+'/img/outdent.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'</div>'+
'<img class="downClass" src="'+dlgpath+'/img/dn.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="justifymenu'+controlsNum+'.style.visibility=\'visible\'">' +

'<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">'+

'<img name="insertorderedlist" alt="Нумерованный список" class="butClass" src="'+dlgpath+'/img/ordlist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="insertunorderedlist" alt="Обычный список" class="butClass" src="'+dlgpath+'/img/bullist.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="inserthorizontalrule" alt="Горизонтальный разделитель" class="butClass" src="'+dlgpath+'/img/rule.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+

'<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">'+

'<img name="createlink" alt="Ссылка" class="butClass" src="'+dlgpath+'/img/link.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<div id="linkmenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onmouseover="this.style.visibility=\'visible\'" onClick="this.style.visibility=\'hidden\'" onmouseout="this.style.visibility=\'hidden\'">'+
'<img name="createanchor" alt="Якорь (метка внутри страницы)" class="butClass" src="'+dlgpath+'/img/anchor.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'</div>'+
'<img class="downClass" src="'+dlgpath+'/img/dn.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="linkmenu'+controlsNum+'.style.visibility=\'visible\';eval(\'iView\'+editSource[ctlMode['+controlsNum+']]+'+controlsNum+').document.body.focus();">' +

'<img border=0 width=2 src="'+dlgpath+'/img/rul.gif">';

 if (obj_id!='')
  htmm+='<img alt="Вставить/изменить рисунок" class="butClass" src="'+dlgpath+'/img/image.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doImage('+controlsNum+')">';

if (!short) {
 htmm+='<img name="createtable" alt="Создать таблицу" class="butClass" src="'+dlgpath+'/img/table.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
//'<div id="tablemenu'+controlsNum+'" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden" onmouseover="this.style.visibility=\'visible\'" onClick="this.style.visibility=\'hidden\'" onmouseout="this.style.visibility=\'hidden\'">'+
'<div id="tablemenu'+controlsNum+'Div" style="border:1px solid #808080;background-color:#76C5F0;margin-top:0pt; position:absolute; visibility:hidden">'+
'<div title="Меню работы с таблицами" onDragStart="alert(1)" style="width:44px;background-color:0A246A" align="right"><img border="0" title="Закрыть" hspace=0 vspace=0 src="'+dlgpath+'/img/x.gif" onClick="tablemenu'+controlsNum+'Div.style.visibility=\'hidden\';return false;"></div>'+
'<!--<img name="modifytable" alt="Изменить свойства таблицы" class="butClass" src="'+dlgpath+'/img/mtable.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="modifycell" alt="Изменить свойства ячейки" class="butClass" src="'+dlgpath+'/img/mcell.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)"><br>-->'+
'<img name="insertrow" alt="Вставить строку" class="butClass" src="'+dlgpath+'/img/insrow.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="removerow" alt="Удалить строку" class="butClass" src="'+dlgpath+'/img/delrow.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)"><br>'+
'<img name="insertcol" alt="Вставить колонку" class="butClass" src="'+dlgpath+'/img/inscol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="removecol" alt="Удалить колонку" class="butClass" src="'+dlgpath+'/img/delcol.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)"><br>'+
'<img name="mergecellright" alt="Объеденить ячейки вправо" class="butClass" src="'+dlgpath+'/img/mrcell.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="mergecelldown" alt="Объеденить ячейки вниз" class="butClass" src="'+dlgpath+'/img/mdcell.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)"><br>'+
'<img name="insertcell" alt="Вставить ячейку" class="butClass" src="'+dlgpath+'/img/inscell.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'<img name="removecell" alt="Удалить ячейку" class="butClass" src="'+dlgpath+'/img/delcell.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'</div>'+
'<img class="downClass" src="'+dlgpath+'/img/dn.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="tablemenu'+controlsNum+'Div.style.visibility=\'visible\';eval(\'iView\'+editSource[ctlMode['+controlsNum+']]+'+controlsNum+').document.body.focus();">' +
'<img src="'+dlgpath+'/img/rul.gif">';
}

htmm+='<img name="clearcode" alt="Отчистить форматирование (после Word, Excel)" class="butClass" src="'+dlgpath+'/img/word.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+

'</td><td bgcolor="#76C5F0" style="padding-right: 3px; padding-top:3px;" align="right">';

 if (isMSIE5 && !isOpera)
  htmm+='<img src="'+dlgpath+'/img/rul.gif">'+
'<img name="maximize" alt="Максимизировать/минимизировать окно редактора" class="butClass" src="'+dlgpath+'/img/max.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doMaxMin('+controlsNum+',this)">';

 htmm+='</td></tr>';

 htmm+='<tr><td colspan="2">';
if (isMSIE5 && !isOpera){
 htmm+='<iframe frameborder="0" id="iViewN'+controlsNum+'" style="border-width:1px; border-style:solid" width="100%" height="100%"></iframe>'+
'<TEXTAREA id="iViewY'+controlsNum+'" name="iViewY'+controlsNum+'" style="border-color: #000000; border-style:solid; border-width:1px; font-family:Varnada; font-size:12px; color:#000000; width: 100%; height:99%"></TEXTAREA>'+
'</td></tr>'+
'<tr><td colspan="2" bgcolor="#76C5F0" height=20 >'+
'<table width=100% cellpadding=0 celspacing=0 border=0 style="padding-left:1pt;color:black;font-family:8pt arial"><td><INPUT TYPE=checkbox ID=cMode'+controlsNum+' ONCLICK="setMode('+controlsNum+',!this.checked);"></td><td><LABEL FOR=cMode'+controlsNum+' style="color: navy;text-decoration: none">Показать&nbsp;HTML</LABEL></td><!--<td><img width=2 height=20 src="'+dlgpath+'/img/rul.gif"></td><td valign=top>'+
'<select style="font-size:8pt;font-family:Arial;" id=fontDrop onChange="doCmd('+controlsNum+',\'fontname|\'+this[this.selectedIndex].value);this.selectedIndex=0">'+
'<option selected>Font'+
'<option value="Times">Times<option value="Arial">Arial'+
'<option value="Verdana">Verdana<option value="Tahoma">Tahoma'+
'<option value="Courier">Courier<option value="Impact">Impact</select>'+
'<select style="font-size:8pt;font-family:Arial;" id=sizeDrop onChange="doCmd('+controlsNum+',\'fontsize|\'+this[this.selectedIndex].value);this.selectedIndex=0">'+
'<option value="" selected>Size'+
'<option value="1">1<option value="2">2<option value="3">3<option value="4">4'+
'<option value="5">5<option value="6">6<option value="7">7</select>'+
'<select style="font-size:8pt;font-family:Arial;" id=sizeDrop onChange="doCmd('+controlsNum+',\'formatblock|\'+this[this.selectedIndex].value);this.selectedIndex=0">'+
'<option value="" selected>Head'+
'<option value="<H1>">H1<option value="<H2>">H2<option value="<H3>">H3'+
'<option value="<H4>">H4<option value="<H5>">H5<option value="<H6>">H6'+
'<option value="<P>">none</select>'+
'</td><td><img name="removeformat" alt="Убрать форматирование" class="butClass" src="'+dlgpath+'/img/clear.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" onClick="doCmd('+controlsNum+',this.name)">'+
'</td><td><img width=2 height=20 src="'+dlgpath+'/img/rul.gif"></td>--><td width=100% align=right><input class="butClass" src="'+dlgpath+'/img/help.gif" onMouseOver="selOn(this)" onMouseOut="selOff(this)" onMouseDown="selDown(this)" onMouseUp="selUp(this)" type="button" onClick="alert(\'Shift+Enter\\tновая строка\\nEnter\\t\\tновый параграф\\nCtrl+K\\t\\tвставить ссылку\\nCtrl+Z\\t\\tотменить последнее действие\');return false" value="?" style="border:1px solid #000000"></td></table></td></tr>';
} else {
 htmm+='<TEXTAREA style="height:'+wheight+';width:100%;" rows="7" cols="50" id="iViewY'+controlsNum+'" name="iViewY'+controlsNum+'" ></TEXTAREA>'+
'</td></tr>'+
'<tr><td colspan="2" bgcolor="#76C5F0" height=20 style="font-family:8pt arial"><INPUT TYPE=checkbox disabled checked><label style="color: navy;text-decoration: underline">Show Source</LABEL> | WYSIWYG disabled, becouse it`s a MSIE applet</td></tr>';
}
 htmm+='</table>';

 document.write(htmm);

 textArea = eval(FormName+"."+FieldName);
 if(isMSIE5 && !isOpera) {
   textArea.style.display="none";
   document.all["iViewY"+controlsNum].value = textArea.value;
   iView=eval("iViewN"+controlsNum);
   with (iView.document)
   { designMode="on";
     open("text/html","replace");
     write(textArea.value);
     close();
   }
   iView.document.focus()
   ctlMode[controlsNum] = 1;
 } else {
   textArea.style.display="none";
   document.all["iViewY"+controlsNum].value = textArea.value;
   document.all["iViewY"+controlsNum].document.body.focus();
   ctlMode[controlsNum]=0;
 }
 eval("document."+FormName).onsubmit=exportHtml;
}