<?php

/***** PARAMETRES ******/
/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "dimanches_to.xlsx";
$inputFileType = "Excel2007";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("TO");
//print_r($objReader);
$objPHPExcel = $objReader->load($inputFileName);
$sheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$i=0;
//print_r($sheet);
$i=1;
$j=0;
$result="<liturgia>";
$resultName="RIEN";
foreach ($sheet as $line) {
		if($line['A']!="") $ref=$line['A'];
		if($line['B']!="") $content['ref'][$i]=$line['B']."_".$ref;
		//if($line['C']!="") $content['ref'][$i]= $line['C'];
    	$content['la'][$i]=$line['C'];
    	$content['fr'][$i]=$line['D'];
    	if($content['ref'][$i]==""){
			$j++;
			$result.="<ligne id=\"".$j."\"><la>".$content['la'][$i]."</la>";
			$result.="<fr>".$content['fr'][$i]."</fr></ligne>";
	}
	else {
		createXML($resultName,$result);
		$resultName=$content['ref'][$i];
		$j=0;
		$result="<liturgia><ligne id=\"0\"><la>".$content['la'][$i]."</la>";
		$result.="<fr>".$content['fr'][$i]."</fr></ligne>";
	}
    	$i++;
}

/*
for($j=1;$j<count($content)+1;$j++){
	if($content['ref'][$j]==""){
		$result.="<ligne id=\"".$j."\"><la>".$content['la'][$j]."</la>";
		$result.="<fr>".$content['fr'][$j]."</fr></ligne>";
	}
	else {
		createXML($resultName,$result);
		$resultName=$content['ref'][$j];
		$result="<liturgia><ligne id=\"1\"><la>".$content['la'][$j]."</la>";
		$result="<fr>".$content['fr'][$j]."</fr></ligne>";
	}
}
*/

function createXML($resultName,$result){
	///DEBUG
	//print"\n  createXML($resultName,$result)";
	print"\r\n";
	print"\r\n".$resultName;
	print"\r\n".$result;
	print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";
	//
	$xml="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	$xml.=$result."</liturgia>";
	$sxe = new SimpleXMLElement($xml); // création et formatage du XML
//$sxe->asXML("calendarium_".$annee.".xml"); // sauvegarde du XML

$sxe->asxml("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$resultName.".xml");	
	
}



?>
