<?php

extractxlsx("commentaires");
function extractxlsx($ref) {
 	
	

 //***** PARAMETRES ******/


/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "corrections_en_cours/".$ref.".xlsx";
$inputFileType = "Excel2007";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("commentaires");
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
		if($line['A']!="") $content['ref'][$i]=$line['A'];
		//print $ref."\r\n";
		$content['la'][$i]=$line['B'];
    	$content['fr'][$i]=$line['C'];
    	//if($content['ref'][$i]==""){
    	if($line['A']==""){
			$j++;
			$result.="<ligne id=\"".$j."\"><fr>".$content['fr'][$i]."</fr></ligne>";
		}
		//elseif(strstr("commentaireEV_",$line['A'])){
		else{	
			//print"\r\n".$result;
			createXML($resultName,$result);
			$resultName=$content['ref'][$i];
			$j=0;
			$result="<liturgia id=\"".$resultName."\"><ligne id=\"0\"><fr>".$content['fr'][$i]."</fr></ligne>";
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


 }

function createXML($resultName,$result){
	
	if(!stristr ( $resultName ,"commentaire")) {
		
	return;
	}
	print"\r\n  createXML($resultName) ";
	print "\r\n*************************************************r\n".$result;
	
	
	///DEBUG
	//print"\n  createXML($resultName,$result)";
	//print"\r\n";
	//print"\r\n".$resultName;
	
	//print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";print"\r\n";
	//
	$xml="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	$xml.=$result."</liturgia>";
	 print "\r\n*************************************************r\n".$xml;
	 print "\r\n*************************************************r\n";
	 print"\r\n".$xml;
	$sxe = new SimpleXMLElement($xml); // création et formatage du XML
//$sxe->asXML("calendarium_".$annee.".xml"); // sauvegarde du XML

$sxe->asxml("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$resultName.".xml");	

/*
$file = "societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$resultName.".xml";
$remote_file = "wp-content/plugins/liturgia/LH/TXT/".$resultName.".xml";

// Mise en place d'une connexion basique
$conn_id = ftp_connect("ftp.societaslaudis.org");

// Identification avec un nom d'utilisateur et un mot de passe
$login_result = ftp_login($conn_id, "societas-fxp", "Adorabo54");
print"\r\n login result = ".$login_result."\r\n ".$file." ====> ".$remote_file."\r\n";
// Charge un fichier
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "Le fichier $file a été chargé avec succès\n";
} else {
 echo "Il y a eu un problème lors du chargement du fichier $file\n";
}

// Fermeture de la connexion
ftp_close($conn_id);
*/
	
}

?>
