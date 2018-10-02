<?php
   
$dir_iterator = new RecursiveDirectoryIterator(dirname(__FILE__));
$iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($iterator as $cle) {
    echo $cle."\n";
	if($cle!="/Users/fxpons/Dropbox/liturgia/laudis/societaslaudis/wp-content/plugins/liturgia/minuscules.php"){
	$newcle=str_replace("HY_", "hy_", $cle);
	
		print $cle." -> ".$newcle."\r\n ";
		rename($cle,$newcle);
		
		 
		$content= file_get_contents ( $newcle);
		$content=str_replace("Ps_", "ps_", $content);
		$content=str_replace("PS_", "ps_", $content);
		$content=str_replace("Hy_", "hy_", $content);
		$newcontent=str_replace("HY_", "hy_", $content);
		$handle = fopen("$newcle", "w+");
		fwrite($handle, $newcontent);
		fclose($handle);
	}
}
   
   
   
   
   
   
   
   
  
   // bool rename ( string $oldname , string $newname [, resource $context ] )
?>