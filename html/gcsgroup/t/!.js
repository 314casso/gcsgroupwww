<script language=javascript>
var aa = new Array("state1","state2","state3");
state1 = new Array("city1","city2");
state2 = new Array("city21","city22","city23");
state3 = new Array("city31","city32","city33");

function changeval()
{
 var val1 = document.sform.sel1.value;
 var optionArray = eval(val1);
 for(var df=0; df<optionArray.length; df++)
 {
  var ss = document.sform.sel2;
  ss.options.length = 0;
  for(var ff=0; ff<optionArray.length; ff++)
  {
   var val = optionArray[ff];
   ss.options[ff] = new Option(val,val);
  }
 }
}
</script>

<form name=sform>
<select name=sel1 onchange=changeval()>
<script language=javascript>
for(var dd=0; dd<aa.length; dd++)
{
 document.write("<option value=\""+aa[dd]+"\">"+aa[dd]+"</option>");
}
</script>
</select>

<select name=sel2>
</select>

</form>