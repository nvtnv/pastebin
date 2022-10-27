<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function randomString($l = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $l;$i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function getNextNumber() {
	$new_number = randomString(10);
	$myFile = "number";
	$handle = @fopen($myFile, "r+b");
	if ($handle) {
		#$line = fgets($handle);
		#fclose($handle);
		
		#$new_id = $line+1;
	
		file_put_contents($myFile,$new_number);
	
		
		return $new_number;
	}
	return 0;

}


if(isset($_POST['submit'])) {
	if (!$_POST['data']) { 
		die ("No input.\n"); 
	}
	$filename = $_POST['filename'];
	if(!$filename) {
		$filename = getNextNumber();
		# Tarkistetaan, että ID:tä ei ole vielä olemassa.
		do {
			$filename = getNextNumber();
		}
		while(file_exists($filename));
	}
	$i = 1;
	$tmp_filename = $filename;
	while(file_exists($filename)) {
		$filename = $tmp_filename . $i++;
	}
	file_put_contents($filename,$_POST['data']);

	echo '<a href=show.php?id='.$filename.'>Teksti tallennettiin</a>';

} else {

?>
Pastebin 0.1

| <a href="show.php">Show</a>

<form name="paste" action="index.php" method="post">
<input type="text" value="filename" name="filename"><br/>
<textarea name="data" rows="25" cols="100"></textarea>
<input type="submit" value="Submit" name="submit">
</form>


<?php
}
?>
