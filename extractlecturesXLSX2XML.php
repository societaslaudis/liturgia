<?php
/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "referencesLecturesMesse.xlsx";
$inputFileType = "Excel2007";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("REF");
$objPHPExcel = $objReader->load($inputFileName);
$sheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
ob_start();

foreach ($sheet as $line) {
	$propre=$line['A'];
    $ref=$line['B'];
    $com=$line['C'];
    $content=$line['D'];
    
		if($com)  {
			
			if($SXEPropre->messe){
				if(!$SXEPropre->messe->$ref) $SXEPropre->messe->addChild($ref);
				if(!$SXEPropre->messe->$ref->$com)$SXEPropre->messe->$ref->addChild($com);
				$nref=$ref;
				if($nref=="LEC2") $nref="LEC";
				$SXEPropre->messe->$ref->$com->addAttribute('id', $nref."_".$content);
			}
			
		 }
		 if((!$com)&&$ref) {
			if($SXEPropre) {
				if(!$SXEPropre->messe->$ref)$SXEPropre->messe->addChild($ref);
				$nref=$ref;
				if($nref=="LEC2") $nref="LEC";
				$SXEPropre->messe->$ref->addAttribute('id', $nref."_".$content);
			}
			
		}
		if($propre!="") {
			print "\r\n".@$filename."\r\n*********\r\n ";
			print_r($SXEPropre->messe);
			if($SXEPropre) $SXEPropre->asxml("sources/propres/".$filename.".xml");
			$SXEPropre=simplexml_load_file("sources/propres/".$propre.".xml");
		$filename=$propre;
		}
}

$txt = ob_get_clean();
$fp = fopen('log.txt', 'w');
fwrite($fp, $txt);

fclose($fp);
?>
