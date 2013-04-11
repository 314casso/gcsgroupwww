		/* Class declaration section */
		
		/* Address class */
		
		function hierarchicalMenu_getAddressPart(indx){
			if(indx<1 || indx>this.length) return -1;
			return this.addr[indx-1];
		}
		
		function hierarchicalMenu_getRelativeAddressParts(count){
			var addr="";
			if(count<=this.length && count>0){
				for(i=0; i<count-1; i++){
					addr+=this.addr[i];
					addr+=".";
				}
				addr+=this.addr[count-1];
			}
			else{
				if(count<1) addr="";
				else{
					addr=this.getAddressParts(this.length);
				}
			}
			return addr;
		}
		function hierarchicalMenu_getAddressParts(count){
			addr=this.getRelativeAddressParts(count);
			if(this.name!=null) return this.name+":"+addr;
			return addr;
		}
		function hierarchicalMenu_getPartitionalAddress(count){
			return new hierarchicalMenu_Address(this.getAddressParts(count));
		}
		
		function hierarchicalMenu_truncate(len){
			if(len<1) this.length=0;
			else{
				if(len<this.length) this.length=len;
			}
		}
		function hierarchicalMenu_toString(){
			return this.getAddressParts(this.length);
		}
		function hierarchicalMenu_toRelativeString(){
			return this.getRelativeAddressParts(this.length);
		}		
		function hierarchicalMenu_equals(addr){
			if(addr.length==this.length && addr.name==this.name){
				for(i=0; i<this.length; i++){
					if(addr.addr[i]!=this.addr[i]) return false;
				}
				return true;
			}
			return false;
		}
		function hierarchicalMenu_isPartOf(addr){
			if(addr.length>this.length && addr.name==this.name){
				for(i=0; i<this.length; i++){
					if(addr.addr[i]!=this.addr[i]) return false;
				}
				return true;			
			}
			return false;
		}
		function hierarchicalMenu_setAddress(addr){
			re=/^(([a-zA-Z]|_|-|\d)+:)?(\d+(\.\d+)*)$/;
			m=addr.match(re);
			if(m!=null && m.length>0){
				address=addr;
				re=/(.+):(.+)/;
				if(addr.match(re)!=null){
					this.name=addr.match(re)[1];
					address=addr.match(re)[2];
				}
				else name=null;
				this.addr=address.split(".");
				this.length=this.addr.length;
			}
			else{
				this.name=null;
				this.addr=null;
				this.length=0;	
			}
		}
		function hierarchicalMenu_compareAddress(addr){
			if(addr.name!=this.name) return 0;
			len=Math.min(this.length, addr.length);
			level=1;
			for(i=1; i<=len; i++){
				if(this.getAddressPart(i)!=addr.getAddressPart(i)) return level;
				level++;					
			}
			return level;
		}
		function hierarchicalMenu_decLength(){
			if(this.length>0) this.truncate(this.length-1);
		}
		function hierarchicalMenu_Address(addr){
			this.setAddress=hierarchicalMenu_setAddress;
			this.getAddressPart=hierarchicalMenu_getAddressPart;
			this.getAddressParts=hierarchicalMenu_getAddressParts;	
			this.getRelativeAddressParts=hierarchicalMenu_getRelativeAddressParts;				
			this.getPartitionalAddress=hierarchicalMenu_getPartitionalAddress;		
			this.truncate=hierarchicalMenu_truncate;
			this.decLength=hierarchicalMenu_decLength;
			this.compareAddress=hierarchicalMenu_compareAddress;
			this.equals=hierarchicalMenu_equals;
			this.isPartOf=hierarchicalMenu_isPartOf;
			this.toRelativeString=hierarchicalMenu_toRelativeString;			
			this.toString=hierarchicalMenu_toString;
			this.setAddress(addr);		
		}	
		
		/* Branch manager class */
		function hierarchicalMenu_hasBranch(addr){
			key="noname";
			if(addr.name!=null && addr.name!="") key=addr.name;
			if(this.branches[key]!=null) return true;
			return false;
		}
		function hierarchicalMenu_getBranch(addr){
			key="noname";
			if(addr.name!=null && addr.name!="") key=addr.name;
			if(this.branches[key]!=null) return this.branches[key];
			return null;
		}		
		function hierarchicalMenu_createBranch(name, multipleSelection){
			if(name==null || name=="") name="noname";
			this.branches[name]=new hierarchicalMenu_Branch(multipleSelection);
		}		
		function hierarchicalMenu_act(node){
			addr=new hierarchicalMenu_Address(node);
			if(this.hasBranch(addr)){
				branch=this.getBranch(addr);
				branch.act(addr);
			}
		}		
		function hierarchicalMenu_expandOnStartup(node){
			addr=new hierarchicalMenu_Address(node);
			if(this.hasBranch(addr)){
				branch=this.getBranch(addr);
				branch.act(addr);
			}
		}		
		function hierarchicalMenu_BranchManager(multipleSelection){
			this.branches=new Array();
			
			this.hasBranch=hierarchicalMenu_hasBranch;
			this.getBranch=hierarchicalMenu_getBranch;		
			this.createBranch=hierarchicalMenu_createBranch;
			this.act=hierarchicalMenu_act;
			this.expandOnStartup=hierarchicalMenu_expandOnStartup;
		}
		
		/* Branch classes declaration */
		function hierarchicalMenu_Branch(multipleSelection){
			if(multipleSelection) this.root=new hierarchicalMenu_MultipleSelectionNode(null, null);
			else this.root=new hierarchicalMenu_SingleSelectionNode(null, null);
			
			this.act=hierarchicalMenu_branchAct;
		}
		function hierarchicalMenu_branchAct(addr){
			this.root.act(addr);
		}
		
		/* Node class */
		function hierarchicalMenu_Node(){
			this.nodeNumber=null;
			this.parentNode=null;
			
			this.expandNode=hierarchicalMenu_expandNode;
			this.collapseNode=hierarchicalMenu_collapseNode;
		
			this.setParentNode=hierarchicalMenu_setParentNode;
			this.isRootNode=hierarchicalMenu_isRootNode;
			this.getNodePath=hierarchicalMenu_getNodePath;
		
			this.expMarker=new Image();
			this.colMarker=new Image();
			this.expMarkerBottom=new Image();
			this.colMarkerBottom=new Image();		
			
			this.expMarker.src="images/menu/expanded_marker.gif";
			this.colMarker.src="images/menu/collapsed_marker.gif";
			this.expMarkerBottom.src="images/menu/expanded_marker_bottom.gif";
			this.colMarkerBottom.src="images/menu/collapsed_marker_bottom.gif";				
		}
		function hierarchicalMenu_setParentNode(parentNode){
			this.parentNode=parentNode;
		}
		function hierarchicalMenu_isRootNode(){
			if(this.parentNode==null && this.nodeNumber==null) return true;
			return false;
		}
		function hierarchicalMenu_getNodePath(){
			if(this.isRootNode()) return null;
			if(this.parentNode!=null && this.parentNode.getNodePath()!=null) return this.parentNode.getNodePath()+"."+this.nodeNumber;
			return this.nodeNumber;
		}
		
		function hierarchicalMenu_expandNode(addr){
			rows=document.all.tags("tr");
			for(u=0; u<rows.length; u++){
				row=rows[u];
				rowNode=new hierarchicalMenu_Address(row.id);
				if(addr.isPartOf(rowNode) && rowNode.length==addr.length+1){
					row.style.display="block";
				}
			}
			images=document.all.tags("img");
			for(u=0; u<images.length; u++){
				image=images[u];
				if(image.name==addr.toString()){
					if(image.src==this.colMarker.src) {
						image.src=this.expMarker.src;
						ttt=document.all["td_"+addr.toString()];
						ttt.background="images/menu/vertical_connector.gif";
						ttt.childNodes[0].src="images/menu/folder_open.gif"
						}
					if(image.src==this.colMarkerBottom.src) {
						image.src=this.expMarkerBottom.src;
						ttt=document.all["td_"+addr.toString()];
						ttt.background="images/menu/vertical_connector.gif";
						ttt.childNodes[0].src="images/menu/folder_open.gif"
						}
				}
			}
		}
		function hierarchicalMenu_collapseNode(addr){
			rows=document.all.tags("tr");
			for(u=0; u<rows.length; u++){
				row=rows[u];
				rowNode=new hierarchicalMenu_Address(row.id);
				if(addr.isPartOf(rowNode) && rowNode.length==addr.length+1){
					row.style.display="none";
				}
			}		
			images=document.all.tags("img");
			for(u=0; u<images.length; u++){
				image=images[u];
				if(image.name==addr.toString()){
					if(image.src==this.expMarker.src){
						 image.src=this.colMarker.src;
						 ttt=document.all["td_"+addr.toString()];
						 ttt.background="";						 
 						 ttt.childNodes[0].src="images/menu/folder.gif";
						 }
					if(image.src==this.expMarkerBottom.src) {
						image.src=this.colMarkerBottom.src;
						ttt=document.all["td_"+addr.toString()];
						ttt.childNodes[0].src="images/menu/folder.gif"
						 ttt.background="";						 
						
						}
				}				
			}		
		}
		
		/* MultipleSelectionNode class */
		
		function hierarchicalMenu_MultipleSelectionNode(parentNode, nodeNumber){
			this.nodeNumber=nodeNumber;
			this.childNodes=new Array();
		
			this.act=hierarchicalMenu_multipleSelectionNode_act;			
			this.isOpenNode=hierarchicalMenu_multipleSelectionNode_isOpenNode;
			this.addNodes=hierarchicalMenu_multipleSelectionNode_addNodes;
			this.closeNodes=hierarchicalMenu_multipleSelectionNode_closeNodes;
			this.closeChildNode=hierarchicalMenu_multipleSelectionNode_closeChildNode;
			this.closeAllChilds=hierarchicalMenu_multipleSelectionNode_closeAllChilds;
			
			if(parentNode!=null) this.setParentNode(parentNode);
		}
		hierarchicalMenu_MultipleSelectionNode.prototype=new hierarchicalMenu_Node;
		
		function hierarchicalMenu_multipleSelectionNode_act(addr){
			if(!this.isOpenNode(addr, 1)){
				this.addNodes(addr, 1);
			}
			else{
				this.closeNodes(addr, 1);
			}
		}
		function hierarchicalMenu_multipleSelectionNode_isOpenNode(addr, level){
			if(level<=addr.length){
				if(this.childNodes[addr.getAddressPart(level)]!=null){
					if(level==addr.length) return true;
					else return this.childNodes[addr.getAddressPart(level)].isOpenNode(addr, ++level);
				}
			}
			return false
		}
		function hierarchicalMenu_multipleSelectionNode_addNodes(addr, level){
			if(level<=addr.length){
				if(this.childNodes[addr.getAddressPart(level)]==null){
					this.childNodes[addr.getAddressPart(level)]=new hierarchicalMenu_MultipleSelectionNode(this, addr.getAddressPart(level));
				}
				this.expandNode(addr.getPartitionalAddress(level));
				this.childNodes[addr.getAddressPart(level)].addNodes(addr, ++level);
			}
		}
		function hierarchicalMenu_multipleSelectionNode_closeNodes(addr, level){
			if(level<addr.length){
				this.childNodes[addr.getAddressPart(level)].closeNodes(addr, ++level);				
			}
			else{
				this.closeChildNode(addr, addr.getAddressPart(level));
			}
		}		
		function hierarchicalMenu_multipleSelectionNode_closeChildNode(addr, num){
			if(this.childNodes[num]!=null){
				this.childNodes[num].closeAllChilds(addr);
				this.collapseNode(new hierarchicalMenu_Address(addr.name+":"+this.childNodes[num].getNodePath()));
				this.childNodes[num]=null;
			}
		}
		function hierarchicalMenu_multipleSelectionNode_closeAllChilds(addr){
			for(var i in this.childNodes){	
				if(this.childNodes[i]!=null){
					this.closeChildNode(addr, i);
				}
			}
		}
		/* SingleSelectionNode class */
		
		function hierarchicalMenu_SingleSelectionNode(parentNode, nodeNumber){
			this.nodeNumber=nodeNumber;
			this.childNode=null;
			
			this.act=hierarchicalMenu_singleSelectionNode_Act;
			this.isOpenNode=hierarchicalMenu_singleSelectionNode_isOpenNode;
			this.addNodes=hierarchicalMenu_singleSelectionNode_addNodes;
			this.closeChildNode=hierarchicalMenu_singleSelectionNode_closeChildNode;
			this.closeAllChilds=hierarchicalMenu_singleSelectionNode_closeAllChilds;
			
			if(parentNode!=null) this.setParentNode(parentNode);
		}
		hierarchicalMenu_SingleSelectionNode.prototype=new hierarchicalMenu_Node;
		
		function hierarchicalMenu_singleSelectionNode_Act(addr){
		
			if(this.isOpenNode(addr, 1)){
				this.closeAllChilds(addr, 1);
			}
			else{
				this.addNodes(addr, 1);				
			}
		}
		function hierarchicalMenu_singleSelectionNode_isOpenNode(addr, level){
			if(level<=addr.length){
				if(this.childNode!=null){
					if(level==addr.length && addr.getAddressPart(level)==this.childNode.nodeNumber) return true;
					if(addr.getAddressPart(level)==this.childNode.nodeNumber){
						return this.childNode.isOpenNode(addr, ++level);
					}
				}
			}
			return false
		}		
		function hierarchicalMenu_singleSelectionNode_addNodes(addr, level){
			if(level<=addr.length){
				if(this.childNode!=null && this.childNode.nodeNumber!=addr.getAddressPart(level)){
					this.closeChildNode(addr);
				}
				if(this.childNode==null){
					this.childNode=new hierarchicalMenu_SingleSelectionNode(this, addr.getAddressPart(level));
					this.expandNode(addr.getPartitionalAddress(level));
				}
				this.childNode.addNodes(addr, ++level);
			}
		}
		function hierarchicalMenu_singleSelectionNode_closeChildNode(addr){
			if(this.childNode!=null){
				this.childNode.closeChildNode(addr);
				this.collapseNode(new hierarchicalMenu_Address(addr.name+":"+this.childNode.getNodePath()));
				this.childNode=null;
			}
		}
		function hierarchicalMenu_singleSelectionNode_closeAllChilds(addr, level){
			if(level<addr.length){
				if(this.childNode!=null) this.childNode.closeAllChilds(addr, ++level);
			}
			else this.closeChildNode(addr);
		}
		/* Variables declaration section */
		
		var hierarchicalMenu_branchManager=new hierarchicalMenu_BranchManager();
