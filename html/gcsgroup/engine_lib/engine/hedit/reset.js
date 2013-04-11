function reset_hedit ()
{
  obj1 = eval('iViewN1').document.body;
  obj2 = eval('iViewN2').document.body;
  obj1.innerHTML = '';
  obj2.innerHTML = '';
  document.editor.reset();
  for (i = 0; i < document.editor.elements.length; i++)
  {
    if (document.editor.elements[i].type == 'text')
    {
	  document.editor.elements[i].value = '';
    }
  }
}

function reset_hedit1()
{
 if (isOpera)
 {
  if (body.value)
  {
   if (confirmClick('очистить содержимое?'))
     body.value='';
  } else {
   body.value='';
  }
  
 }else { 
  if (ctlMode[1]==1){
   if (eval('iViewN1').document.body.innerHTML){
    if (confirmClick('очистить содержимое?'))
     eval('iViewN1').document.body.innerHTML='';
   } else {
     eval('iViewN1').document.body.innerHTML='';
   } 
  } else {
   if (document.all["iViewY1"].value) {
    if (confirmClick('очистить содержимое?'))
     document.all["iViewY1"].value='';
   }else {
    document.all["iViewY1"].value='';
   }
  }
 }
}
