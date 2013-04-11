?><?
$i=0;
if ($dir = opendir("ch_images")) {
  while ($file = readdir($dir)) {
    if (!is_dir($file)) {
		$f[$i]=$file;
		$i++;
		}
  }  
  closedir($dir);
 if ($i) echo "ch_images/".$f[rand(0,$i-1)];
 else echo "images/plav.jpg";
}
else echo "images/plav.jpg";
?>

