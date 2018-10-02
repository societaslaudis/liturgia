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
$objPHPExcel->getProperties()->setTitle("RB");
$objPHPExcel->getProperties()->setSubject("RB");
$objPHPExcel->getProperties()->setDescription("RB - generated using PHP classes.");
$i=1;
// Selectiond e toutes les références RB
chdir ( "societaslaudis/wp-content/plugins/liturgia/LH/TXT/" );
foreach (glob("RB_*.xml") as $filename) {
    
	preces2xlsx($filename);
	
	
} 
 echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('RB');

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

chdir ( "../../../../../../" );
$objWriter->save('corrections_en_cours/RB.xlsx');

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
 
 function preces2xlsx($ref){
 global $objPHPExcel;
 global $i;
 
 echo $ref." \n";
 $sxe=simplexml_load_file($ref);
 $ref=str_ireplace ( ".xml" , "" , $ref );
 //print_r($sxe->ligne);
 $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $ref); 
  for($j=0;$j<count($sxe);$j++){
  	print $i." ->".$sxe->ligne[$j]->la[0]."\n";
  	//print $j." ".$sxe->ligne[$j]['la']."\r";
  	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $sxe->ligne[$j]->la[0]);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $sxe->ligne[$j]->fr[0]);
  	$i++;
  }
	
 

}

?>