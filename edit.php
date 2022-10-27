<?php

$files = glob('*');
usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});




if($_GET['id'] ||
$_GET['last']) {
	$filename = 'number';
	print '<form method="post" action="edit.php">';
	$handle = @fopen($filename, "r+b");
	if(isset($_GET['last'])) {
		$filename = fgets($handle);
                fclose($handle); 	
	} else {
		$filename = $_GET['id'];
	}
	#$filectime = filectime($filename);

	#$grace = strtotime("today -30 day 12:00");
	#//print "debug: filectime: $filectime grace: $grace \n";
	#if($filectime < $grace) {
	#	die("no access");
	#}

	$handle = @fopen($filename, "r");
	
	if ($handle) {
		print '<textarea rows=50 cols=150 name=data>';
	    while (($buffer = fgets($handle, 4096)) !== false) {
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		$buffer = str_replace($order, $replace, $buffer);
		$buffer = str_replace("<br />", "\n", $buffer);
#	$buffer = str_replace('[b]', '<b>', $buffer);
#		$buffer = str_replace('[/b]', '</b>', $buffer);
		echo $buffer;
	    }
		print '</textarea>';
	    if (!feof($handle)) {
		echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	}
	print '<br/>';

	print '<input type="hidden" name="file" value="'.basename($_SERVER['PHP_SELF']).'">';
	print '<input type="hidden" name="id" value="'.$_GET['id'].'">';
	print '<input type="submit" name="submit">';
	print '</form>';
}
if(isset($_POST['submit'])) {
	$id = $_POST['id'];
	if (!$_POST['data']) { die ("No input.\n"); }
        unlink($id); 
	file_put_contents($id,$_POST['data']);

        echo '<a href=edit.php?id='.$id.'>Teksti tallennettiin</a>';

}
function dirToArray($dir) { 
   
   $result = array(); 

   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".",".."))) 
      { 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
         } 
         else 
         { 
            $result[] = $value; 
         } 
      } 
   } 
   
   return $result; 
} 
?>
