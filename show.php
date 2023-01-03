<?php

error_reporting( E_ALL ); 
ini_set('display_errors', 1);

$files = glob('*');
usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});

$colors = array(
0 => '#C71585',
1 => '#CD5C5C',
2 => '#CD853F', 
3 => '#D2691E',
4 => '#D2B48C',
5 => '#D3D3D3',
6 => '#D8BFD8',
7 => '#DA70D6',
8 => '#6A5ACD',
9 => '#7CFC00',
10 => '#663399',
11 => '#228B22'
); 
	

print '<table border=1>';
foreach($files as $file){
	if (preg_match("/php(~)?$/i", $file)) { continue; }
	if($file == 'number' or $file == 'deleted') { continue; }
	$line_count = count(file($file));
	$show_max_lines = '';
	if($line_count >= 5) {
		$show_max_lines = 5;
	} else {
		$show_max_lines = 1;
	}
	$show_file_content = "";
	for($i=0;$i<$show_max_lines;$i++) {
		$show_file_content .= file($file)[$i]."<br>\n";
	}
	if($show_max_lines >= 5) { 
		$show_file_content .= "<br>\n...jatkuu...<br>\n"; 
	}
	$show_file_content = str_replace('[b]', '<b>', $show_file_content);
	$show_file_content = str_replace('[/b]', '</b>', $show_file_content);
	$file_unix_time = ord($file);
	$tr_bg = ' alt='.$file_unix_time.'  bgcolor='.$colors[$file_unix_time%(sizeof($colors))];
    	printf('<tr%4$s><td><input type="checkbox" name="box[]"></td>
        	<td><a href="edit.php?id=%1$s">%1$s</a></td>
		<td>%2$s</td> 
		<td>%3$s</td>
            	<td><a href="delete.php?file=%1$s">delete<a></td></tr>',
		$file, 
		$show_file_content='', 
		date('F d Y, H:i:s', filemtime($file)),
		$tr_bg);
	

}
print '</table>';


if($_GET['id'] ||
$_GET['last']) {
	$filename = 'number';
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
	    while (($buffer = fgets($handle, 4096)) !== false) {
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		$buffer = str_replace($order, $replace, $buffer);
		$buffer = str_replace('[b]', '<b>', $buffer);
		$buffer = str_replace('[/b]', '</b>', $buffer);
		echo $buffer;

	    }
	    if (!feof($handle)) {
		echo "Error: unexpected fgets() fail\n";
	    }
	    fclose($handle);
	}
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
