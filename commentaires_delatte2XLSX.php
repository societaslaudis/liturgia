<?php
/** PARAMETRES **/
//$jourAGenerer="20171203";
/** PHPExcel_IOFactory */
include "PHPExcel/Classes/PHPExcel/IOFactory.php";
/** inclusions des bibliothèques "liturgia" **/
include "societaslaudis/wp-content/plugins//liturgia/LH/fonctions.php";

 //****
/* CREATION D UN FICHIER XLS
/*******/

/** Error reporting */
//error_reporting(E_ALL);

// Create new PHPExcel object
echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("FXP");
$objPHPExcel->getProperties()->setLastModifiedBy("FXP");
$objPHPExcel->getProperties()->setTitle("delatte");
$objPHPExcel->getProperties()->setSubject("delatte");
$objPHPExcel->getProperties()->setDescription("delatte - generated using PHP classes.");
$i=1;
// Selectiond e toutes les références PRECES
chdir ( "societaslaudis/wp-content/plugins/liturgia/LH/TXT/" );
foreach (glob("EV_*.xml") as $filename) {
    
	CONV2xlsx($filename);
	
	
} 
 echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('commentaires');

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

chdir ( "../../../../../../" );
$objWriter->save('corrections_en_cours/commentaires.xlsx');

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
 
 function CONV2xlsx($ref){
 global $objPHPExcel;
 global $i;
 
 //echo $ref." \n";
 $sxe=simplexml_load_file($ref);
 print"\r\n".$ref;
 $pathrefcom= "commentaire".basename($ref);
 print"\r\n".$pathrefcom."\r\n";
 $refcom="commentaire".basename($ref,".xml");
 $sxeCOM=@simplexml_load_file($pathrefcom);
 //print_r($sxe->ligne);
 $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, basename($ref,".xml")); 
  for($j=0;$j<count($sxe);$j++){
  	//print $i." ->".$sxe->ligne[$j]->la[0]."\n";
  	//print $j." ".$sxe->ligne[$j]['la']."\r";
  	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($sxe->ligne[$j]->la[0]));
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($sxe->ligne[$j]->fr[0]));
	
	$i++;
  }
  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "commentaire".basename($ref,".xml")); 
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, "Commentaire par Dom Paul Delatte (1848-1937), osb, abbé de saint Pierre de Solesmes"); 
  $i++;
  	if(@$sxeCOM){
		print_r($sxeCOM);
		for($k=0;$k<count($sxe);$k++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($sxeCOM->ligne[$k]->fr[0]));
			$i++;
		}
		
	}
 

}

?>
