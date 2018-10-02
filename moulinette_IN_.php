<?php

$dir    = 'sources/propres';
$files = scandir($dir,1);

//print_r($files);
$i=0;
while($files[$i]){
	print "\r\n ----**---- TRAITEMENT / ".$files[$i];
	if(!is_dir("sources/propres/".$files[$i])){
		$ORG=file_get_contents("sources/propres/".$files[$i]);
		//$ORG=str_replace ( "IN_" , "IN" , $ORG );
		$ORG=str_replace ( '<IN id="IN' , '<IN id="IN_' , $ORG );
		
		$sxe=simplexml_load_string($ORG) or die("ERREUR : ".$files[$i]);;
		$sxe->asXML("sources/propres/".$files[$i]);
	}
	$i++;
}


?>
