<?

/*
 *  $Id: $
 */
 
$ptrn[0] = "/(\w+)\s*=\s*'((~'|[^'])+)'/Usi";
$ptrn[1] = "/(\w+)\s*=\s*(.+)($|\s)/Usi";
$ptrn[2] = "/(\w+)\s*=\s*\"((~\"|[^\"])+)\"/Usi";
for ($j = 0; $j <= 2; $j++) {
	preg_match_all($ptrn[$j], $given, $regs, PREG_SET_ORDER);
	$i = 0;
	while ($regs[$i][0]) {
	    if ($i == 0)
	    	$regs[$i][2] = str_replace("~'", "'", $regs[$i][2]);
	    elseif ($i == 2)
	    	$regs[$i][2] = str_replace("~\"", "\"", $regs[$i][2]);
	    //global ${$regs[$i][1]};
	    //${$regs[$i][1]} = $regs[$i][2];
	    $_SESSION[trim($regs[$i][1])] = trim($regs[$i][2]);
	    $i++;
	}
}
?>