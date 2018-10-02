<?php
include_once("lune.php");
date_default_timezone_set('Europe/Paris');

//include_once("get_traduction.php");
$p=pathinfo("__FILE__");
$pathinfo=$p['dirname'];
print "\r\n PATHINFO = ".$pathinfo."\r\n";
/*
function no_accent($str_accent) {
   $pattern = Array("/ /","/Æ/","/é/", "/è/", "/ê/", "/ç/", "/æ/","/à/", "/á/", "/í/", "/ï/", "/ù/", "/ó/","/ú/","/,/","/__/","/:/");
   // notez bien les / avant et après les caractères
   $rep_pat = Array("_","A","e", "e", "e", "c", "ae","a", "a", "i", "i", "u", "o", "u","_","_",null,null);
   $str_noacc = preg_replace($pattern, $rep_pat, $str_accent);
   $str_noacc=trim($str_noacc,"_");
   $str_noacc = preg_replace($pattern, $rep_pat, $str_noacc);
   $str_noacc = str_replace("*", null, $str_noacc);
   $str_noacc = str_replace("?", null, $str_noacc);
   $str_noacc=trim($str_noacc);
   $str_noacc=str_replace("__", "_", $str_noacc);
   return $str_noacc;
}

*/

/*
$xml=simplexml_load_file("Martyrologe_source.xml");
$select=$xml->xpath("//sect3");
$date=0;

$output="<xml>";
foreach($select as $tt) {
$output.= "\r\n <jour id='".$date."'>\r\n <date >".trim($tt[0]->title)."</date>";
	$id=0;
	//print_r($tt->para);
	foreach($tt->para as $para){
		$output.="\r\n<item id='".$id."'>".$para[0]."</item>";
		$id++;
	}
	$output.= "</jour>";
	$date++;
}
$output.="</xml>";
$xmlmarty=$output;
*/
//fwrite($fp, $xmlmarty);
//fclose($fp);

$martyrologeromain=simplexml_load_file("martyrologeromain.xml");
  
/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "Calendrier_RE.xlsx";
$inputFileType = "Excel2007";
$sheetname="Vierge Marie";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
//print "Loading Sheet ".$sheetname." only\r\n";
$objReader->setLoadSheetsOnly("Vierge Marie");
$objPHPExcel = $objReader->load($inputFileName);

$sheetDataBVM = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Saint de Jerusalem");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataJerusalem = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Biographie et ...") or die ("Erreur biographie");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataBio = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Vierge Marie") or die ("Erreur Vierge Marie");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataBVM = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$objReader->setLoadSheetsOnly("Piété populaire") or die ("Erreur Piété populaire");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataPP = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

function piete($pp,$dateTS){
	$result=$pp;
	if ($pp=="Quatre temps - Avent") $result="Quatre temps de l'Avent";
	//if(trim($result)!="") $result.=", ";
	if (date("w",$dateTS)==5) $result.=" Abstinence";
	//$result=$pp;
	return $result;
}


function pietePopulaire($cel,$temporal,$piete,$date_ts) {
	
	
	
	GLOBAL $sheetDataPP;
	$output="\r\n<piete>";
	$ff=get_firstFriday(date("m",$date_ts),(date("Y",$date_ts)));
	if ($ff==date("Ymd",$date_ts)) {$output.="\r\n <intitule>1er vendredi du mois dédié au Sacré Cœur de Jésus.</intitule>";
	//print"\r\n 1_Vendredi : ".date("Ymd",$date_ts);
	//sleep(5);
	}
	$fs=get_firstSaturday(date("m",$date_ts),(date("Y",$date_ts)));
	if ($fs==date("Ymd",$date_ts)) $output.="\r\n <intitule>1er samedi du mois dédié au Cœur Immaculée de Marie.</intitule>";
		
	foreach ($sheetDataPP as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if(($Md!="-")&&($Md==date('n-j',$date_ts))) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	
	//print "\r\n piete".$piete;
	
	//if($piete) print"\r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n ".$piete."\r\n \r\n \r\n \r\n \r\n ";
	/// piété mobile
	//print"\r\n temporal = ".$temporal;
	
	foreach ($sheetDataPP as $line) {
		//if($piete) print "\r\n ".$piete. " || ".$line['G'];
		if(($piete)&&(trim($line['G'])==trim($piete))) {
			$output.="\r\n <intitule>".$line['F']."</intitule>";
			print"\r\n OKOKOKOK ".$line['F'];
			//sleep(5);
		}
		if(($temporal)&&(trim($line['G'])==trim($temporal))) {
			if($line['F']) $output.="\r\n <intitule>".$line['F']."</intitule>";
			print"\r\n OKOKOKOK ".$line['F'];
			//sleep(5);
		}
		if(($cel)&&(trim($line['G'])==trim($cel))) {
			if($line['F']) $output.="\r\n <intitule>".$line['F']."</intitule>";
			print"\r\n OKOKOKOK ".$line['F'];
			//sleep(5);
		}
		
	}
	
	
	
	$output.="</piete>\r\n";
	if($piete!="") $output="<piete><intitule>".$calendarium[$thisdate_Ymd]['piete']."</intitule></piete>";
	
	return $output;
}




$objReader->setLoadSheetsOnly("Journées dédiées") or die ("Journées dédiées");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataJD = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

function journeesdediees($id,$date_ts) {
	
	GLOBAL $sheetDataJD;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="\r\n<journeesdediees>";
	foreach ($sheetDataJD as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	$output.="</journeesdediees>\r\n";
	return $output;
}

$objReader->setLoadSheetsOnly("Cal Civil") or die ("Cal Civil");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataCivil = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

function calendriercivil($id,$date_ts) {
	GLOBAL $sheetDataCivil;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="\r\n<calendriercivil>";
	foreach ($sheetDataCivil as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
			}	
	}
	$output.="</calendriercivil>\r\n";
	return $output;
}

//$xmlmarty=simplexml_load_file("martyrologe.xml");

function martyrologe($date_ts,$code) {
	
	global $martyrologeromain;
	global $calendarium;
	
	
	//print_r($martyrologeromain);
	//print "\r\n !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!".$code;
	
	
	$expr="//jour[@id='".$code."']";
	//print " ".$code." ".$expr;
	$result=$martyrologeromain->xpath($expr);
	if($result) {
		//print_r($result);
		$output="<para>".$result[0]->title."</para><para>".$result[0]->notice."</para>";
		//print "\r\n ".$output;
	}
	
	$jr=date('j-n',$date_ts);
	$expr="//jour[@id='".$jr."']";
	
	//print"\r\n  ".$expr;
	$result=$martyrologeromain->xpath($expr);
	$output.="<para>".$result[0]->title."</para>";
	foreach ($result[0]->notice as $r) {
		//print_r($r);
		$output.="<para>".$r."</para>";
	}
	 
	 //print "\r\n".$output;
	//print_r($result);
	//sleep(10);
	//print $output;
	return $output;
}

function biographie($date_ts) {
	GLOBAL $sheetDataBio;
	//print"\r\n sheetDataBio= "; print_r($sheetDataBio);
	//print"\r\n dbug BIO ".date('n-j',$date_ts);
	$output="\r\n<biographie>";
	foreach ($sheetDataBio as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
			if($Md==date('n-j',$date_ts)) {
				$output.="\r\n <intitule>".$line['E']."</intitule>";
				$output.="\r\n <biographiecourte>".$line['G']."</biographiecourte>";
				$output.="\r\n <canonisebeatifie>".$line['H']."</canonisebeatifie>";
				$output.="\r\n <patronage>".$line['J']."</patronage>";
			}	
	}
	$output.="</biographie>\r\n";
	return $output;
}

function viergeMarie($date_ts) {
	GLOBAL $sheetDataBVM;
	//print"\r\n dbug BVM ".date('n-j',$date_ts);
	$output="\r\n<viergemarie>";
	foreach ($sheetDataBVM as $line) {
		$Md=trim($line['A'])."-".trim($line['D']);
		//print"\r\n \"".$Md."\" =>".date('n-j',$date_ts);
			if($Md==date('n-j',$date_ts)) {
				print"\r\n ".date('n-j',$date_ts)." ".$Md;
				$output.="\r\n <intitule>".$line['E']." ".$line['F']."</intitule>";
			}	
	}
	$output.="</viergemarie>\r\n";
	return $output;
}

$compendiumxml=simplexml_load_file("compendium.xml");

function compendium($date_ts) {
	GLOBAL $compendiumxml;
	$debutanneedelafoi=mktime(12, 0, 0, 10, 11, 2012 );
	$r=$date_ts-$debutanneedelafoi;
	if($r>=0) {
		$j=round($r/(60*60*24));
		$expr="//article[@id=\"".$j."\"]";
		$output=$compendiumxml->xpath($expr);
		//print"\r\n ".$expr;
		//print "\r\n ".$output[0];
		return $output[0];
	}
}

function Jerusalem($date_ts) {
	GLOBAL $sheetDataJerusalem;
	//$inputFileType = 'Excel5';
	//	$inputFileType = 'Excel2007';
	//	$inputFileType = 'Excel2003XML';
	$inputFileType = 'OOCalc';
	//	$inputFileType = 'Gnumeric';


	//print"\r\n dbug Jerusalem ".date('n-j',$date_ts);
	$output="\r\n<jerusalem>";
	foreach ($sheetDataJerusalem as $line) {
		if($line['E']!="") {
			$Md=(string)$line['A']."-".$line['D'];
			if($Md==(string)date('n-j',$date_ts)) {
				$output.="\r\n <texte>".$line['E']."</texte>";
				//print "\r\n <texte>".$line['E']."</texte>";
			}

		}
	}
	$output.="</jerusalem>\r\n";
	/*
	 print $objPHPExcel->getSheetCount()." worksheet".(($objPHPExcel->getSheetCount() == 1) ? '' : 's')." loaded\r\n \r\n";
	 $loadedSheetNames = $objPHPExcel->getSheetNames();
	 foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
	 print $sheetIndex." -> ".$loadedSheetName."<br />";
	 }
	 */
	//print"\r\n".$output;
	return $output;
}

function get_firstFriday($month,$year){
 	for ($i=1;$i<8;$i++) {
    $num = date("w",mktime(0,0,0,$month,$i,$year));
    if($num==5) return date("Ymd",mktime(0,0,0,$month,$i,$year));
 	}
}

function get_firstSaturday($month,$year){
 	for ($i=1;$i<8;$i++) {
    $num = date("w",mktime(0,0,0,$month,$i,$year));
    if($num==6) return date("Ymd",mktime(0,0,0,$month,$i,$year));
 	}
}

?>
