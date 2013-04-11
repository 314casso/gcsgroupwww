 isDOM=document.getElementById //DOM1 browser (MSIE 5+, Netscape 6, Opera 5+)

 isNetscape4=document.layers //Netscape 4.*
 isOpera=navigator.userAgent.indexOf("Opera")>=0 //Opera

 isOpera7=(navigator.userAgent.indexOf("Opera 7")>=0) || (navigator.userAgent.indexOf("Opera/7")>=0);
 isOpera5=isOpera && isDOM && !isOpera7 //Opera 5+

 isMSIE=document.all && document.all.item && !isOpera //Microsoft Internet Explorer 4+

 isMSIE5=isDOM && isMSIE && !isOpera //MSIE 5+

 isMozilla=isNetscape6=isDOM && !isMSIE && !isOpera //Mozilla или Netscape 6.*

 function getObject(obj)
 {
   if (isDOM) return document.getElementById(obj)
   else if (isMSIE) return document.all[obj]
   return null;
 }
