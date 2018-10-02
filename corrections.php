<?php

/*****
 * 
 * PARAMETRES
 * 
 * 
 */

$dateYmd_debut="20171226";
$dateYmd_fin="20171231";

/****
 * 
 * 
 * 
 * 
 * 
 * ****/
include_once ("journeeLiturgique2xlsx.php");
include_once ("extractjourneeLiturgiqueXLSX.php");

function dateYmd2dateTS($Ymd) {
	date_default_timezone_set('UTC');
	$anno=substr($Ymd,0,4);
	$mense=substr($Ymd,4,2);
	$die=substr($Ymd,6,2);
	$ts=mktime(12,0,0,$mense,$die,$anno);
	//print"\r\n".$date_ts;
	return $ts;
}



$dts=dateYmd2dateTS($dateYmd_debut);
$dts_fin=dateYmd2dateTS($dateYmd_fin);

print"\r\n".$dts." ".date('Ymd',$dts);
for($i=0;$dts<$dts_fin;$i++){
	print"\r\n \r\n ************************ journeeLiturgique2xlsx(".date('Ymd',$dts).") \r\n";
	
	journeeLiturgique2xlsx(date('Ymd',$dts));
	$dts=$dts+86400;	
}

print "\r\n Faire vos corrections et enregistrer les feuilles XLS. O/n";
$val = trim(fgets(STDIN));
if($val !="n"){
	$dts=dateYmd2dateTS($dateYmd_debut);
	for($i=0;$dts<$dts_fin+86400;$i++){
	print"\r\n \r\n ************************ extractJourneeLiturgique(".date('Ymd',$dts).") \r\n";
	
	extractJourneeLiturgiqueXLSX(date('Ymd',$dts));
	$dts=$dts+86400;	
	}
}
?>
