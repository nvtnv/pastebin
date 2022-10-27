<?php
if(isset($_GET['file'])) {
        if(FALSE !== system("mv '".$_GET['file']."' 'deleted/".$_GET['file']."'")) {
		print "poistettu";
	}
   	     
}
?>
