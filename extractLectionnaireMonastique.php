<?php

/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "lectionnaire_monastique_perannum12-15.xlsx";
$inputFileType = "Excel2007";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("lectionnaire");
$objPHPExcel = $objReader->load($inputFileName);
$sheetLectionnaire = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$i=0;
//print_r($sheetLectionnaire);
foreach ($sheetLectionnaire as $line) {
		
    	$lectionnaire[$i]['la']=$line['A'];
    	$lectionnaire[$i]['fr']=$line['B'];
    	$lectionnaire[$i]['id']=$line['C'];
		
		$i++;
		//print "\r\r\r\r\r ".$i.$lectionnaire[$i]['la']=$line['A']." ".$lectionnaire[$i]['fr']=$line['B']." ".$lectionnairel[$i]['id']=$line['C'];
}
//print_r($lectionnaire);
/// Routine analse du contenu et creation des xml
for ($i=0;$i<1500;$i++){	

	if(substr($lectionnaire[$i]['id'],0,3)=="LB_") {
		/// DEBUG
		//print"\n";
		//print $lectionnaire[$i]['id'];
		///
		creeLB($lectionnaire,$i);
	}	
	elseif(substr($lectionnaire[$i]['id'],0,5)=="VERS_") {
		/// DEBUG
		//print"\n";
		//print $lectionnaire[$i]['id'];
		///
		creeVERS($lectionnaire,$i);
	}
	elseif($lectionnaire[$i]['id']!=""){
		// DEBUG
		print"\n ".$lectionnaire[$i]['id'];
		//
		creeLectureRepons($lectionnaire,$i);
	}	
}
		

function creeLectureRepons($lectionnaire,$n){
	///DEBUG
	print"\n creeLectureRepons($lectionnaire,$n)";
	
	//
	$xml="<?xml version=\"1.0\"?>
	<liturgia> <ligne id=\"1\">
<la>".$lectionnaire[$n]['la'].")</la><fr>".$lectionnaire[$n]['fr'].")</fr></ligne>";

	for($o=1;$lectionnaire[$n+$o]['id']=="";$o++){
	$xml.="<ligne id=\"".$o."\">
<la>".$lectionnaire[$n+$o]['la']."</la>
<fr>".$lectionnaire[$n+$o]['fr']."</fr>
</ligne>";
	}
	$xml.="</liturgia>";
	$sxe = new SimpleXMLElement($xml); // création et formatage du XML
//$sxe->asXML("calendarium_".$annee.".xml"); // sauvegarde du XML

$sxe->asxml("outputLECT/".$lectionnaire[$n]['id'].".xml");	
	
}

function creeLB($lectionnaire,$n){
	$xml="<?xml version=\"1.0\"?>
<liturgia> <ligne id=\"1\">
<la>Lectio brevis (".$lectionnaire[$n]['la'].")</la><fr>Lecture br&#xE8;ve (".$lectionnaire[$n]['fr'].")</fr></ligne>
<ligne id=\"2\">
<la>".$lectionnaire[$n+1]['la']."</la>
<fr>".$lectionnaire[$n+1]['fr']."</fr>
</ligne>
</liturgia>";
// DEBUG
//print "\n\n\n".$lectionnaire[$n]['id']."\n $n \n".$xml;
///////
$sxe = new SimpleXMLElement($xml); // création et formatage du XML
//$sxe->asXML("calendarium_".$annee.".xml"); // sauvegarde du XML

$sxe->asxml("outputLECT/".$lectionnaire[$n]['id'].".xml");	
}

function creeVERS($lectionnaire,$n){
	///DEBUG
	print"\n creeVERS($lectionnaire,$n)";
	//
	$xmlVERS="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<versus id=\"".$lectionnaire[$n]['id']."\">
<la>".$lectionnaire[$n]['la']."</la>
<fr>".$lectionnaire[$n]['fr']."</fr>
</versus>";
$sxe = new SimpleXMLElement($xmlVERS); // création et formatage du XML
$sxe->asxml("outputLECT/".$lectionnaire[$n]['id'].".xml");	
	
}
