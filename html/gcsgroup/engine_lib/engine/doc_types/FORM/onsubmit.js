
document.all.field_count.value=count;
for (i=0;i<= count ;i++) {
	inp=eval("document.all.field"+i);
	td=eval("document.all.td"+i);
	inp.value=td.innerHTML;
	}

