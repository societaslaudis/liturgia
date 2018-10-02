<?php

include_once("fonctions.php");
include_once("ressources.php");
$xmlS = simplexml_load_file("sanctoral_messe.xml");


$annee="2018";
print"\r\n Début du script.";
$cal[0]=genere_calendarium($annee,"RE");
print"\r\n genere_calendarium($annee,RE)";

//$cal[1]=genere_calendarium($annee,"SWF");
//print"\r\n genere_calendarium($annee,SWF)";

//$cal[2]=genere_calendarium($annee,"SMK");
//print"\r\n genere_calendarium($annee,SMK)";

//file_put_contents("cal_RE.txt", $cal[0]);

cal2XML($cal,$annee);
print"\r\n cal2XML(cal,$annee);";


$sanctoral = array();
function genere_calendarium($annee="",$ordo="") {

if ($ordo=="RE") {
	$lang="la";
	$continent="Europe";
	$lieu="France";
	$pays="France";
	$diocese="Saint-Etienne";
	$local="";
}
if($ordo=="SMK"){
	$lang="la";
	$continent="Europe";
	$pays="France";
	$lieu="";
	$diocese="Bénédictin";
	$local="SMK";
}
if($ordo=="SWF"){
	$lang="la";
	$continent="Europe";
	$pays="France";
	$lieu="";
	$diocese="Bénédictin";
	$local="SWF";
}
if($ordo=="CSM"){
	$lang="la";
	$continent="Europe";
	$pays="France";
	$lieu="France";
	$diocese="CSM";
	$local="";
}




/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "celebrations_mobiles.xlsx";
$inputFileType = "Excel2007";

print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$cycle="cycle_avent";
if($lieu=="France") $cycle="cycle_avent_france";
$objReader->setLoadSheetsOnly($cycle);
$objPHPExcel = $objReader->load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//print"\r\n".$cycle;
foreach ($sheetData as $line) {
		//$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D'],$annee);
    	//$dds=date("Ymd", $date_sanctoral);
    	//Ordre	Code	Intitule	Priorite	Rang	Hebdomada	HP	Tempus	Couleur	1V	Messe_Vigile	Messe	Messe_autre	Messe_autre2	Piete
    	
    	$ordre=$line['A'];
		//print"\r\n ".$ordre;
		$cycle_avent[$ordre]['code']=$line['B'];
    	$cycle_avent[$ordre]['intitule']=$line['C'];
    	$cycle_avent[$ordre]['priorite']=$line['D'];
    	$cycle_avent[$ordre]['rang']=$line['E'];
    	$cycle_avent[$ordre]['hebdomada']=$line['F'];
		$cycle_avent[$ordre]['HP']=$line['G'];
		$cycle_avent[$ordre]['tempus']=$line['H'];
		$cycle_avent[$ordre]['couleur']=$line['I'];
		$cycle_avent[$ordre]['1V']=$line['J'];
		$cycle_avent[$ordre]['messe_vigile']=$line['K'];
		$cycle_avent[$ordre]['messe']=$line['L'];
		$cycle_avent[$ordre]['messe_autre']=$line['M'];
		$cycle_avent[$ordre]['messe_autre2']=$line['N'];
		$propre=no_accent($cycle_avent[$ordre]['intitule']);
		//if($propre != $cycle_avent[$ordre]['code']) 
		$cycle_avent[$ordre]['propre']=$propre;
		$propre="";
		$cycle_avent[$ordre]['piete']=$line['O'];
		$cycle_avent[$ordre]['special']=$line['P'];
		$cycle_avent[$ordre]['plus']=$line['Q'];
		//print"\r \n ".$ordre." ".$cycle_avent[$ordre]['code'];
}
//sleep(10);
$cycle="cycle_paques";
if($lieu=="France") $cycle="cycle_paques_france";
$objReader->setLoadSheetsOnly($cycle);
$objPHPExcel = $objReader->load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetData as $line) {
		$ordre=$line['A'];
		$cycle_paques[$ordre]['code']=$line['B'];
    	$cycle_paques[$ordre]['intitule']=$line['C'];
    	$cycle_paques[$ordre]['priorite']=$line['D'];
    	$cycle_paques[$ordre]['rang']=$line['E'];
    	$cycle_paques[$ordre]['hebdomada']=$line['F'];
		$cycle_paques[$ordre]['HP']=$line['G'];
		$cycle_paques[$ordre]['tempus']=$line['H'];
		$cycle_paques[$ordre]['couleur']=$line['I'];
		$cycle_paques[$ordre]['1V']=$line['J'];
		$cycle_paques[$ordre]['messe_vigile']=$line['K'];
		$cycle_paques[$ordre]['messe']=$line['L'];
		$cycle_paques[$ordre]['messe_autre']=$line['M'];
		$cycle_paques[$ordre]['messe_autre2']=$line['N'];
		$propre=no_accent($cycle_paques[$ordre]['intitule']);
		//if($propre != $cycle_paques[$ordre]['code']) 
		$cycle_paques[$ordre]['propre']=$propre;
		$propre="";
		@$cycle_paques[$ordre]['piete']=$line['O'];
		@$cycle_paques[$ordre]['special']=$line['P'];
		@$cycle_paques[$ordre]['plus']=$line['Q'];
}


$cycle="cycle_nativite";
if($lieu=="France") $cycle="cycle_nativite_france";

$objReader->setLoadSheetsOnly($cycle);
$objPHPExcel = $objReader->load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetData as $line) {
		$ordre=$line['A'];
		$cycle_nativite[$ordre]['code']=$line['B'];
    	$cycle_nativite[$ordre]['intitule']=$line['C'];
    	$cycle_nativite[$ordre]['priorite']=$line['D'];
    	$cycle_nativite[$ordre]['rang']=$line['E'];
    	$cycle_nativite[$ordre]['hebdomada']=$line['F'];
		$cycle_nativite[$ordre]['HP']=$line['G'];
		$cycle_nativite[$ordre]['tempus']=$line['H'];
		$cycle_nativite[$ordre]['couleur']=$line['I'];
		$cycle_nativite[$ordre]['1V']=$line['J'];
		$cycle_nativite[$ordre]['messe_vigile']=$line['K'];
		$cycle_nativite[$ordre]['messe']=$line['L'];
		$cycle_nativite[$ordre]['messe_autre']=$line['M'];
		$cycle_nativite[$ordre]['messe_autre2']=$line['N'];
		$cycle_nativite[$ordre]['piete']=$line['O'];
		$propre=no_accent($cycle_nativite[$ordre]['intitule']);
		$cycle_nativite[$ordre]['propre']=$propre;		$propre="";
		@$cycle_nativite[$ordre]['special']=$line['P'];
		@$cycle_nativite[$ordre]['plus']=$line['Q'];
}




$inputFileName = "Calendrier_RE.xlsx";
$inputFileType = "Excel2007";
print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
print "\r\n continent = ".$continent." pays=".$pays." diocese=".$diocese." lieu = ".$lieu." local=".$local;
$objReader->setLoadSheetsOnly("Cal général Romain");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataSanctoral = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetDataSanctoral as $line) {
	
		$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D'],$annee);
    	$dds=date("Ymd", $date_sanctoral);
    	$sanctoral[$dds]['intitule']=$line['E'];
    	$sanctoral[$dds]['rang']=$line['F'];
    	$sanctoral[$dds]['couleur']=$line['G'];
    	$sanctoral[$dds]['priorite']=$line['H'];
		$sanctoral[$dds]['1V']=$line['N'];
		$sanctoral[$dds]['messe_vigile']=$line['O'];

}



if($continent) {
$objReader->setLoadSheetsOnly("Cal ".$continent);
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataSanctoralContinent = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
print"\r\n ////////////// Integre le continent ".$continent." !!!!!!!!!!!!!!!!!!!!!";

foreach ($sheetDataSanctoralContinent as $line) {
	//print_r($line);
	$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D'],$annee);
	
    	$dds=date("Ymd", $date_sanctoral);
    	if($line['E']){ $sanctoral[$dds]['intitule']=$line['E'];
			print"\r\n ".$dds." ".$sanctoral[$dds]['intitule'];
		}
    	if($line['F']) $sanctoral[$dds]['rang']=$line['F'];
    	if($line['G']) $sanctoral[$dds]['couleur']=$line['G'];
    	if($line['H']) {$sanctoral[$dds]['priorite']=$line['H'];
			print" ".$sanctoral[$dds]['priorite'];
    	}
		if($line['N'])$sanctoral[$dds]['1V']=$line['N'];

}

}

if($pays) {
$objReader->setLoadSheetsOnly("Cal ".$pays);
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataSanctoralPays = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetDataSanctoralPays as $line) {
	$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D'],$m);
    	$dds=date("Ymd", $date_sanctoral);
    	if($line['E']) {$sanctoral[$dds]['intitule']=$line['E'];}
    	if($line['F']) $sanctoral[$dds]['rang']=$line['F'];
    	if($line['G']) $sanctoral[$dds]['couleur']=$line['G'];
    	if($line['H']) $sanctoral[$dds]['priorite']=$line['H'];

}


}



if($diocese) {
$objReader->setLoadSheetsOnly("Cal ".$diocese);
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataSanctoralDiocese = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetDataSanctoralDiocese as $line) {
	$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D'],$m);
    	$dds=date("Ymd", $date_sanctoral);
    	if($line['E']) $sanctoral[$dds]['intitule']=$line['E'];
    	if($line['F']) $sanctoral[$dds]['rang']=$line['F'];
    	if($line['G']) $sanctoral[$dds]['couleur']=$line['G'];
    	if($line['H']) $sanctoral[$dds]['priorite']=$line['H'];

}

}

print"\r\n lieu = ".$lieu;
if($lieu=="France") { // Nous sommes en France, on met l'épiphanie au 2ème dimanche après la Nativité
	// donc on retire du sanctoral le 6 janvier.
	print"\r\n Nous sommes en France, on met l'épiphanie au 2ème dimanche après la Nativité // donc on retire du sanctoral le 6 janvier.";
	$sanctoral[$annee."0106"]="";
}
	
$feriae=array("Dominica","Feria II","Feria III","Feria IV","Feria V","Feria VI","Sabbato");
$romains=array("","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII","XIII","XIV","XV","XVI","XVII","XVIII","XIX","XX","XXI","XXII","XXIII","XXIV","XXV","XXVI","XXVII","XXVIII","XXIX","XXX","XXXI","XXXII","XXXIII","XXXIV");
$menses=array("","Ianuarii","Februarii","Martii","Aprilii","Maii","Iunii","Iulii","Augusti","Septembri","Octobri","Novembri","Decembri");



	


//// Intégration cycle de L'Avent
/// Calcul du jour du 4ème dimanche de l'Avent :
$noel_ts=mktime(12,0,0,12,25,$annee);
$journoel=date("w",$noel_ts);
if ($journoel==0) $journoel=7;
$quatre_dim_avent_ts=$noel_ts-($journoel*60*60*24);



//sleep(10);
$thisdate_ts=$quatre_dim_avent_ts;
$thisIndex="218";
$calendarium[date('Ymd',$thisdate_ts)]=$cycle_avent[$thisIndex];
//$output.="\r\n /// Intégration cycle de L'Avent +";

for($thisIndex=218;date("Y",$thisdate_ts)==$annee;$thisIndex++) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_avent[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_avent[$thisIndex]['code'];
		if(@$cycle_avent[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_avent[$thisIndex]['intitule'];
    	if(@$cycle_avent[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_avent[$thisIndex]['priorite'];
    	if(@$cycle_avent[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_avent[$thisIndex]['rang'];
    	if(@$cycle_avent[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_avent[$thisIndex]['hebdomada'];
		if(@$cycle_avent[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_avent[$thisIndex]['HP'];
		if(@$cycle_avent[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_avent[$thisIndex]['tempus'];
		if(@$cycle_avent[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_avent[$thisIndex]['couleur'];
		if(@$cycle_avent[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_avent[$thisIndex]['1V'];
		if(@$cycle_avent[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_avent[$thisIndex]['intitule'];
		if(@$cycle_avent[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_avent[$thisIndex]['messe'];
		if(@$cycle_avent[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_avent[$thisIndex]['messe_autre'];
		if(@$cycle_avent[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_avent[$thisIndex]['propre'];
		if(@$cycle_avent[$thisIndex]['piete']!="")$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_avent[$thisIndex]['piete'];
		if(@$cycle_avent[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['special']=$cycle_avent[$thisIndex]['special'];
		if(@$cycle_avent[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_avent[$thisIndex]['plus'];
		
		//if(@$cycle_avent[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_avent[$thisIndex]['special'];	
		$thisdate_ts=$thisdate_ts+(60*60*24);
		//if(date("Y",$thisdate_ts)!=$annee) break;
}



// Calcul de la date du 2ème dimanche après la nativité :
// A année - 1 : 4ème dimanche de l'Avent :
$noelanneeprecedente_ts=mktime(12,0,0,12,25,$annee-1);
$journoelanneeprecedente=date("w",$noelanneeprecedente_ts);
if ($journoelanneeprecedente==0) $journoelanneeprecedente=7;
$quatre_dim_aventanneeprecedente_ts=$noelanneeprecedente_ts-($journoelanneeprecedente*60*60*24);
$deuxiemedimancheapreslanativite_ts=$quatre_dim_aventanneeprecedente_ts+60*60*24*14;
$thisdate_ts=$deuxiemedimancheapreslanativite_ts;
print"\r\n noelanneeprecedente_ts = ".date("Ymd",$noelanneeprecedente_ts);
print"\r\n quatre_dim_aventanneeprecedente = ".date("Ymd",$quatre_dim_aventanneeprecedente_ts);
print"\r\n deuxiemedimancheapreslanativite = ".date("Ymd",$deuxiemedimancheapreslanativite_ts);
for($thisIndex=232;date("Y",$thisdate_ts)==$annee;$thisIndex++) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_avent[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_avent[$thisIndex]['code'];
		if(@$cycle_avent[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_avent[$thisIndex]['intitule'];
    	if(@$cycle_avent[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_avent[$thisIndex]['priorite'];
    	if(@$cycle_avent[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_avent[$thisIndex]['rang'];
    	if(@$cycle_avent[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_avent[$thisIndex]['hebdomada'];
		if(@$cycle_avent[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_avent[$thisIndex]['HP'];
		if(@$cycle_avent[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_avent[$thisIndex]['tempus'];
		if(@$cycle_avent[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_avent[$thisIndex]['couleur'];
		if(@$cycle_avent[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_avent[$thisIndex]['1V'];
		if(@$cycle_avent[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_avent[$thisIndex]['intitule'];
		if(@$cycle_avent[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_avent[$thisIndex]['messe'];
		if(@$cycle_avent[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_avent[$thisIndex]['messe_autre'];
		if(@$cycle_avent[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_avent[$thisIndex]['propre'];
		if(@$cycle_avent[$thisIndex]['piete']!="")$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_avent[$thisIndex]['piete'];	
		if(@$cycle_avent[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['special']=$cycle_avent[$thisIndex]['special'];
		if(@$cycle_avent[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_avent[$thisIndex]['plus'];
		$thisdate_ts=$thisdate_ts+(60*60*24);
		//if(date("Y",$thisdate_ts)!=$annee) break;
}







$thisdate_ts=$quatre_dim_avent_ts;
$output.="\r\n /// Intégration cycle de L'Avent - ".$annee;

for($thisIndex=218;date("Y",$thisdate_ts)==$annee;$thisIndex--) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_avent[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_avent[$thisIndex]['code'];
		if(@$cycle_avent[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_avent[$thisIndex]['intitule'];
    	if(@$cycle_avent[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_avent[$thisIndex]['priorite'];
    	if(@$cycle_avent[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_avent[$thisIndex]['rang'];
    	if(@$cycle_avent[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_avent[$thisIndex]['hebdomada'];
		if(@$cycle_avent[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_avent[$thisIndex]['HP'];
		if(@$cycle_avent[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_avent[$thisIndex]['tempus'];
		if(@$cycle_avent[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_avent[$thisIndex]['couleur'];
		if(@$cycle_avent[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_avent[$thisIndex]['1V'];
		if(@$cycle_avent[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_avent[$thisIndex]['intitule'];
		if(@$cycle_avent[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_avent[$thisIndex]['messe'];
		if(@$cycle_avent[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_avent[$thisIndex]['messe_autre'];
		if(@$cycle_avent[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_avent[$thisIndex]['propre'];
		if(@$cycle_avent[$thisIndex]['piete']!="")$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_avent[$thisIndex]['piete'];		
		if(@$cycle_avent[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['special']=$cycle_avent[$thisIndex]['special'];
		if(@$cycle_avent[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_avent[$thisIndex]['plus'];
		//print "\r \n ".date('Y m d H:i',$thisdate_ts)." ".$thisIndex." ".$cycle_avent[$thisIndex]['code'];
		$thisdate_ts=$thisdate_ts-(60*60*24);
		//if(date("Y",$thisdate_ts)!=$annee) break;
}

/// Intégration du cyle de Noël
$thisdate_ts=mktime(12,0,0,12,17,$annee);
for($thisIndex=1;date("Y",$thisdate_ts)==$annee;$thisIndex++) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_nativite[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_nativite[$thisIndex]['code'];
		if(@$cycle_nativite[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_nativite[$thisIndex]['intitule'];
    	if(@$cycle_nativite[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_nativite[$thisIndex]['priorite'];
    	if(@$cycle_nativite[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_nativite[$thisIndex]['rang'];
    	if(@$cycle_nativite[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_nativite[$thisIndex]['hebdomada'];
		if(@$cycle_nativite[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_nativite[$thisIndex]['HP'];
		if(@$cycle_nativite[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_nativite[$thisIndex]['tempus'];
		if(@$cycle_nativite[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_nativite[$thisIndex]['couleur'];
		if(@$cycle_nativite[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_nativite[$thisIndex]['1V'];
		//if(@$cycle_nativite[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_nativite[$thisIndex]['intitule'];
		if(@$cycle_nativite[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_nativite[$thisIndex]['messe'];
		//if(@$cycle_nativite[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_nativite[$thisIndex]['messe_autre'];
		if(@$cycle_nativite[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_nativite[$thisIndex]['propre'];
		if(@$cycle_nativite[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['special']=$cycle_nativite[$thisIndex]['special'];
		if(@$cycle_nativite[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_nativite[$thisIndex]['plus'];
		if(@$cycle_nativite[$thisIndex]['piete']!="")$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_nativite[$thisIndex]['piete'];	
		$thisdate_ts=$thisdate_ts+(60*60*24);
		//if(date("Y",$thisdate_ts)!=$annee) break;
}

/// Intégration cycle de Pâques
$easter_ts= easter_date($annee );	
$paques_ts=mktime(12,0,0,date("m",$easter_ts),date("d",$easter_ts),$annee);
$thisdate_ts=$paques_ts;
$paquesYmd=date("Ymd",$paques_ts);
$thisIndex=64;
$calendarium[date('Ymd',$thisdate_ts)]=$cycle_paques[$thisIndex];
//$output.="\r\n /// Intégration cycle de Pâques +";
for($thisIndex=64;date("Y",$thisdate_ts)==$annee;$thisIndex++) {
	
	//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_paques[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=@$cycle_paques[$thisIndex]['code'];
		if(@$cycle_paques[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=@$cycle_paques[$thisIndex]['intitule'];
    	if(@$cycle_paques[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=@$cycle_paques[$thisIndex]['priorite'];
    	if(@$cycle_paques[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=@$cycle_paques[$thisIndex]['rang'];
    	if(@$cycle_paques[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=@$cycle_paques[$thisIndex]['hebdomada'];
		if(@$cycle_paques[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=@$cycle_paques[$thisIndex]['HP'];
		if(@$cycle_paques[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=@$cycle_paques[$thisIndex]['tempus'];
		if(@$cycle_paques[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=@$cycle_paques[$thisIndex]['couleur'];
		if(@$cycle_paques[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=@$cycle_paques[$thisIndex]['1V'];
		//if(@$cycle_paques[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=@$cycle_paques[$thisIndex]['intitule'];
		if(@$cycle_paques[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=@$cycle_paques[$thisIndex]['messe'];
		//if(@$cycle_paques[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=@$cycle_paques[$thisIndex]['messe_autre'];
		if(@$cycle_paques[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=@$cycle_paques[$thisIndex]['propre'];
		if(@$cycle_paques[$thisIndex]['piete'])$calendarium[date('Ymd',$thisdate_ts)]['piete']=@$cycle_paques[$thisIndex]['piete'];
		if(@$cycle_paques[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_paques[$thisIndex]['special'];
		if(@$cycle_paques[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_paques[$thisIndex]['plus'];
	//$calendarium[date('Ymd',$thisdate_ts)]=$cycle_paques[$thisIndex];
	$thisdate_ts=$thisdate_ts+(60*60*24);
}
$thisdate_ts=$paques_ts;
//$output.="\r\n /// Intégration cycle de Pâques -";
for($thisIndex=64;date("Y",$thisdate_ts)==$annee;$thisIndex--) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_paques[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_paques[$thisIndex]['code'];
		if(@$cycle_paques[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_paques[$thisIndex]['intitule'];
    	if(@$cycle_paques[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_paques[$thisIndex]['priorite'];
    	if(@$cycle_paques[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_paques[$thisIndex]['rang'];
    	if(@$cycle_paques[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_paques[$thisIndex]['hebdomada'];
		if(@$cycle_paques[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_paques[$thisIndex]['HP'];
		if(@$cycle_paques[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_paques[$thisIndex]['tempus'];
		if(@$cycle_paques[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_paques[$thisIndex]['couleur'];
		if(@$cycle_paques[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_paques[$thisIndex]['1V'];
		//if(@$cycle_paques[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_paques[$thisIndex]['intitule'];
		if(@$cycle_paques[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_paques[$thisIndex]['messe'];
		//if(@$cycle_paques[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_paques[$thisIndex]['messe_autre'];
		if(@$cycle_paques[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_paques[$thisIndex]['propre'];
		if(@$cycle_paques[$thisIndex]['piete']) {
			$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_paques[$thisIndex]['piete'];
			print "\r\n ...... ".$cycle_paques[$thisIndex]['piete'];
		}
		if(@$cycle_paques[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_paques[$thisIndex]['special'];
		if(@$cycle_paques[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_paques[$thisIndex]['plus'];
		
		//if(date("Y",$thisdate_ts)!=$annee) break;
		$thisdate_ts=$thisdate_ts-(60*60*24);
}



$thisdate_ts=mktime(12,0,0,1,1,$annee);
for($thisIndex=16;date("Y",$thisdate_ts)==$annee;$thisIndex++) {
		
		//$output.="\r\n".$thisIndex." ".date("Ymd",$thisdate_ts);
		if(@$cycle_nativite[$thisIndex]['code']) $calendarium[date('Ymd',$thisdate_ts)]['code']=$cycle_nativite[$thisIndex]['code'];
		if(@$cycle_nativite[$thisIndex]['intitule']) $calendarium[date('Ymd',$thisdate_ts)]['intitule']=$cycle_nativite[$thisIndex]['intitule'];
    	if(@$cycle_nativite[$thisIndex]['priorite'])$calendarium[date('Ymd',$thisdate_ts)]['priorite']=$cycle_nativite[$thisIndex]['priorite'];
    	if(@$cycle_nativite[$thisIndex]['rang'])$calendarium[date('Ymd',$thisdate_ts)]['rang']=$cycle_nativite[$thisIndex]['rang'];
    	if(@$cycle_nativite[$thisIndex]['hebdomada']) $calendarium[date('Ymd',$thisdate_ts)]['hebdomada']=$cycle_nativite[$thisIndex]['hebdomada'];
		if(@$cycle_nativite[$thisIndex]['HP'])$calendarium[date('Ymd',$thisdate_ts)]['HP']=$cycle_nativite[$thisIndex]['HP'];
		if(@$cycle_nativite[$thisIndex]['tempus'])$calendarium[date('Ymd',$thisdate_ts)]['tempus']=$cycle_nativite[$thisIndex]['tempus'];
		if(@$cycle_nativite[$thisIndex]['couleur'])$calendarium[date('Ymd',$thisdate_ts)]['couleur']=$cycle_nativite[$thisIndex]['couleur'];
		if(@$cycle_nativite[$thisIndex]['1V'])$calendarium[date('Ymd',$thisdate_ts)]['1V']=$cycle_nativite[$thisIndex]['1V'];
		//if(@$cycle_nativite[$thisIndex]['messe_vigile'])$calendarium[date('Ymd',$thisdate_ts)]['messe_vigile']=$cycle_nativite[$thisIndex]['intitule'];
		if(@$cycle_nativite[$thisIndex]['messe'])$calendarium[date('Ymd',$thisdate_ts)]['messe']=$cycle_nativite[$thisIndex]['messe'];
		//if(@$cycle_nativite[$thisIndex]['messe_autre'])$calendarium[date('Ymd',$thisdate_ts)]['messe_autre']=$cycle_nativite[$thisIndex]['messe_autre'];
		if(@$cycle_nativite[$thisIndex]['propre'])$calendarium[date('Ymd',$thisdate_ts)]['propre']=$cycle_nativite[$thisIndex]['propre'];
		if(@$cycle_nativite[$thisIndex]['special'])$calendarium[date('Ymd',$thisdate_ts)]['special']=$cycle_nativite[$thisIndex]['special'];
		if(@$cycle_nativite[$thisIndex]['plus'])$calendarium[date('Ymd',$thisdate_ts)]['plus']=$cycle_nativite[$thisIndex]['plus'];
		if(@$cycle_nativite[$thisIndex]['piete']!="")$calendarium[date('Ymd',$thisdate_ts)]['piete']=$cycle_nativite[$thisIndex]['piete'];
		$thisdate_ts=$thisdate_ts+(60*60*24);
		//if(date("Y",$thisdate_ts)!=$annee) break;
}




///// Particularites ordo annuel
$inputFileName="celebrations_mobiles.xlsx";
print"\r\nLoading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setLoadSheetsOnly("particularites_annuelles");
$objPHPExcel = $objReader->load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$i=0;
foreach ($sheetData as $line) {
	if($line['A']==$annee) {
		$ddd=$line['C'];
		$ccc=$line['B'];
		$eee=$line['D'];
		//$calendarium[$ddd][$ccc]="";
		//if($calendarium[$ddd]['code']==$bbb) { 
		//On copie les éléments
		$sanctoral[$eee]['code']=@$sanctoral[$ddd]['code'];
		$sanctoral[$eee]['intitule']=@$sanctoral[$ddd]['intitule'];
		$sanctoral[$eee]['priorite']=@$sanctoral[$ddd]['priorite'];
		$sanctoral[$eee]['rang']=@$sanctoral[$ddd]['rang'];
		$sanctoral[$eee]['couleur']=@$sanctoral[$ddd]['couleur'];
		$sanctoral[$eee]['1V']=@$sanctoral[$ddd]['1V'];
		// On efface
		$sanctoral[$ddd]['code']="";
		$sanctoral[$ddd]['intitule']="";
		$sanctoral[$ddd]['priorite']="";
		$sanctoral[$ddd]['rang']="";
		$sanctoral[$ddd]['couleur']="";
		$sanctoral[$ddd]['1V']="";
		//}
	}
}


/// INTEGRATION DU SANCTORAL.
$date_ts=mktime(12,0,0,1,1,$annee);

while(date("Y",$date_ts)==$annee) {
	
	if(@$sanctoral[date("Ymd",$date_ts)]['intitule']) { 
		//$output.="\r\n".date('Ymd',$date_ts)." ".$sanctoral[date("Ymd",$date_ts)]['intitule'];
		if(
		(!@$calendarium[date('Ymd',$date_ts)]['priorite'])
		||
		(@$sanctoral[date("Ymd",$date_ts)]['priorite']&&($sanctoral[date("Ymd",$date_ts)]['priorite']<$calendarium[date("Ymd",$date_ts)]['priorite'])
		)
		){
		//if($sanctoral[date("Ymd",$date_ts)]['priorite']&&($sanctoral[date("Ymd",$date_ts)]['priorite']<$calendarium[date("Ymd",$date_ts)]['priorite'])) {
			$propre=$sanctoral[date("Ymd",$date_ts)]['intitule'];
			if(@$sanctoral[date("Ymd",$date_ts)]['priorite']<12) $calendarium[date('Ymd',$date_ts)]['propre']=no_accent($propre);
			if(@$sanctoral[date("Ymd",$date_ts)]['intitule']) $calendarium[date('Ymd',$date_ts)]['intitule']=$sanctoral[date("Ymd",$date_ts)]['intitule'];
	    	if(@$sanctoral[date("Ymd",$date_ts)]['priorite'])$calendarium[date('Ymd',$date_ts)]['priorite']=$sanctoral[date("Ymd",$date_ts)]['priorite'];
	    	if(@$sanctoral[date("Ymd",$date_ts)]['rang'])$calendarium[date('Ymd',$date_ts)]['rang']=$sanctoral[date("Ymd",$date_ts)]['rang'];
	    	if(@$sanctoral[date("Ymd",$date_ts)]['couleur'])$calendarium[date('Ymd',$date_ts)]['couleur']=$sanctoral[date("Ymd",$date_ts)]['couleur'];
			if(@$sanctoral[date("Ymd",$date_ts)]['1V'])$calendarium[date('Ymd',$date_ts)]['1V']=$sanctoral[date("Ymd",$date_ts)]['1V'];
			//if(@$sanctoral[date("Ymd",$date_ts)]['messe_vigile'])$calendarium[date('Ymd',$date_ts)]['messe_vigile']=$sanctoral[date("Ymd",$date_ts)]['messe_vigile'];
			if(@$sanctoral[date("Ymd",$date_ts)]['messe'])$calendarium[date('Ymd',$date_ts)]['messe']=$sanctoral[date("Ymd",$date_ts)]['messe'];
			//if(@$sanctoral[date("Ymd",$date_ts)]['messe_autre'])$calendarium[date('Ymd',$date_ts)]['messe_autre']=$sanctoral[date("Ymd",$date_ts)]['messe_autre'];
			if(@$sanctoral[date("Ymd",$date_ts)]['piete'])$calendarium[date('Ymd',$date_ts)]['piete']=$sanctoral[date("Ymd",$date_ts)]['piete'];
			$propre="";	
			//print"\r\n".date('Ymd',$date_ts)." ".$calendarium[date('Ymd',$date_ts)]['code']." ";
			//if(no_accent($calendarium[date('Ymd',$date_ts)]['intitule']) !=$calendarium[date('Ymd',$date_ts)]['code']) print no_accent($calendarium[date('Ymd',$date_ts)]['intitule'])." ";
			//print $calendarium[date('Ymd',$date_ts)]['intitule']." ".$calendarium[date('Ymd',$date_ts)]['piete'];
		}
	}
	$date_ts=$date_ts+(60*60*24);	
	
 }



$calendarium['ordo']=$ordo;

//// GENERATION OUTPUT - calendrier mensuel
$date_ts=mktime(12,0,0,1,1,$annee);
$ox="<calendarium an=\"".$annee."\">";
while(date("Y",$date_ts)==$annee) {
	/// Calcul année A, B ou C.
	//$ann[]={"","A","B","C"};
	$diff=$annee-1969;
	$annABC=$diff%3;
	
	$lettre_annee=array("A","B","C");
	
	$increment=0;
	if(
		(date("m",$date_ts)=="11")
		&&
		($calendarium[date("Ymd",$date_ts)]["tempus"]=="Tempus Adventus")
		||
		(date("m",$date_ts)==11)&&($calendarium[date("Ymd",$date_ts)]["tempus"]=="Tempus Adventus")
		||(date("m",$date_ts)=="12")&&($calendarium[date("Ymd",$date_ts)]["tempus"]=="Tempus Adventus")
		||(date("m",$date_ts)=="12")&&($calendarium[date("Ymd",$date_ts)]["tempus"]=="Tempus Nativitatis")
	) {
		//// ici décalage d'un mois de l'année A, B ou C
		$increment=1;
		
	}
	$annABC=$annABC+$increment;
	if($annABC==3) $annABC=0;
	$l=$lettre_annee[$annABC];
	if(!$l) $l="A";
	$calendarium[date("Ymd",$date_ts)]['lettre_annee']=$l;
	
	//print"\n";
	
	
// DATE Ymd
	$output.="\r\n".date('Ymd',$date_ts)." ";
	$ox.="<elt annee='".$l."' date='".date('Ymd',$date_ts)."'>";
	// psautier
	$ps=$calendarium[date('Ymd',$date_ts)]['HP'].date("w",$date_ts)+1;
	$ox.="<psalterium id='".$ps."' />";
	$output.="psalterium_".$ps." ";
	// Code
	$output.=$calendarium[date('Ymd',$date_ts)]['code']." ";
	$ox.="<code id='".$calendarium[date('Ymd',$date_ts)]['code']."' />";
	// propre (temps)
	if(
		(no_accent(@$calendarium[date('Ymd',$date_ts)]['intitule']) !=$calendarium[date('Ymd',$date_ts)]['code'])
		&&
		(no_accent(@$calendarium[date('Ymd',$date_ts)]['intitule']) !=$calendarium[date('Ymd',$date_ts)]['propre'])
		&&
		($calendarium[date('Ymd',$date_ts)]['priorite']<11)
	)
			{
			 	$output.= no_accent($calendarium[date('Ymd',$date_ts)]['intitule'])." ";
				$ox.="<propre id='".no_accent($calendarium[date('Ymd',$date_ts)]['intitule'])."' />";
				
			}
	// propre (saints)
	$output.= @$calendarium[date('Ymd',$date_ts)]['propre']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['propre']) $ox.="<propre id='".$calendarium[date('Ymd',$date_ts)]['propre']."' />"; 
	// favent (féries de l'Avent)
	if(@$calendarium[$thisdate_Ymd]['favent']) $output.= @$calendarium[$thisdate_Ymd]['favent']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['favent']) $ox.="<special id='".$calendarium[date('Ymd',$date_ts)]['favent']."' />"; 
	$output.= $calendarium[date('Ymd',$date_ts)]['favent']." ";
	// special
	if(@$calendarium[date('Ymd',$date_ts)]['special']) $output.= @$calendarium[date('Ymd',$date_ts)]['special']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['special']) $ox.="<special id='".$calendarium[date('Ymd',$date_ts)]['special']."' />"; 
	$output.= $calendarium[date('Ymd',$date_ts)]['special']." ";
	
	// plus
	$output.= @$calendarium[date('Ymd',$date_ts)]['plus']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['plus']) $ox.="<plus id='".$calendarium[date('Ymd',$date_ts)]['plus']."' />"; 
	$output.= $calendarium[date('Ymd',$date_ts)]['plus']." ";
	
	// intitule
	$output.= @$calendarium[date('Ymd',$date_ts)]['intitule']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['intitule']) $ox.="<intitule>".$calendarium[date('Ymd',$date_ts)]['intitule']."</intitule>"; 
	// priorite
	if(@$calendarium[date('Ymd',$date_ts)]['priorite']) $ox.="<priorite id='".$calendarium[date('Ymd',$date_ts)]['priorite']."' />"; 
	// piété
	$output.= @$calendarium[date('Ymd',$date_ts)]['piete']." ";
	if(@$calendarium[date('Ymd',$date_ts)]['piete']) $ox.="<piete id='".$calendarium[date('Ymd',$date_ts)]['piete']."' />"; 
	
	if(@$calendarium[date('Ymd',$date_ts)]['rang']) $ox.="<rang>".$calendarium[date('Ymd',$date_ts)]['rang']."</rang>";
	
	// 1ères vêpres
	if(@$calendarium[date('Ymd',$date_ts)]['1V']==1) $output.="1V";
	if(@$calendarium[date('Ymd',$date_ts)]['1V']) $ox.="<premieresvepres>".$calendarium[date('Ymd',$date_ts)]['1V']."</premieresvepres>"; 
	
	$date_ts=$date_ts+60*60*24;	
	$ox.="</elt>";
	}	
$ox.="</calendarium>";
//print"\r\n \r\n  ICI";
//print $ox;
$sxe = new SimpleXMLElement($ox); // création et formatage du XML
$sxe->asXML("calendarium_".$annee.".xml"); // sauvegarde du XML
if($ordo=="RE"){
	

$fichier=fopen('test.log','w'); 
fwrite($fichier,$output); 
fclose($fichier); 
}
//sleep(30);
return $calendarium;
}




function cal2XML($cal,$annee) {
	
	$traductions=$lst=simplexml_load_file("../societaslaudis/wp-content/plugins/liturgia/LH/traductions.xml");
	$thisdate_ts=mktime(12,0,0,1,1,$annee);
		
	/*
	 * 
	 * BOUCLE qui parcourt l'année et qui créée à chaque fois un fichier par jour avec tout.
	 * 
	 */
	 
	 
	while(date("Y",$thisdate_ts)==$annee) {
		
	$thisdate_Ymd=date("Ymd",$thisdate_ts);
	$liturgia=null; // remise à z du tableau pour ne pas avoir des copies d'un jour sur l'autre;	
		$liturgia['office_soir_la']="";
		$liturgia['intitule_soir_la']="";
		$liturgia['rang_soir_la']="";
		$output="<calendarium>";

		for($p=0;$p<count($cal);$p++) {
			
			$calendarium=$cal[$p];
			if (date('Y',$thisdate_ts)%2 == 0) $parite="paire";
			else $parite="impaire";
			if($calendarium[$thisdate_Ymd]['tempus']=="Tempus Adventus"){
				if ($parite=="impaire") $parite="paire";
				else $parite="impaire";
			}
			$calendarium[$thisdate_Ymd]['parite']=$parite;
			$thisdemain_Ymd=date("Ymd",$thisdate_ts+60*60*24);
			
			$filename="calendrier/".@date("Y-m-d",$thisdate_ts).".xml";
						
			$messe=$calendarium[$thisdate_Ymd]['code'];
			if($calendarium[$thisdate_Ymd]['propre']) $messe=$calendarium[$thisdate_Ymd]['propre'];
			
			
			
			/*
			 * 
			 * TODO : POINT PARTICULIER A VERIFIER POUR LES MESSES APRES L'EPIHANIE
			 * 
			 * 
			 * 
			*/
			
			
			/*
			if(($tableau['matin']['cel']!="IN_EPIPHANIA_DOMINI") && ($tempus=="Tempus nativitatis post Epiphaniam"))  {
				$jjr=date('w',$date_courante)+1;
				
				if ($jjr!=1) {
					$messe="postepi_".$jjr;
					$tableau['matin']['cel']="postepi_".$jjr;
				}
			}
			*/
			
			
			$liturgia['lettre']=$calendarium[$thisdate_Ymd]['lettre_annee'];
			$output.="\r\n<ordo id=\"".$calendarium['ordo']."\">";
			//$output.="\r\n<messe>".$messe."</messe>";
			$output.="\r\n<lettre_annee>".$liturgia['lettre']."</lettre_annee>";
			$output.="\r\n<priorite>".$calendarium[$thisdate_Ymd]['priorite']."</priorite>";
			if(($calendarium[$thisdate_Ymd]['tempus']=="Tempus Adventus")&&($calendarium[$thisdate_Ymd]['rang']  == 13 ) ){
				$calendarium[$thisdate_Ymd]['couleur']="";
			}
			$output.="\r\n<couleur>".$calendarium[$thisdate_Ymd]['couleur']."</couleur>";
			$output.="\r\n<code>".$calendarium[$thisdate_Ymd]['code']."</code>";
			$output.="\r\n<propre>".$calendarium[$thisdate_Ymd]['propre']."</propre>";
			
			//$output.="\r\n<reference>".$calendarium[$thisdate_Ymd]['reference']."</reference>";
			
			$output.="\r\n<sanctoral><la>".$calendarium[$thisdate_Ymd]['sanctoral']."</la><fr>".get_traduction($calendarium[$thisdate_Ymd]['sanctoral'],"fr",$traductions)."</fr></sanctoral>";
			
			$output.="\r\n<tempus><la>".$calendarium[$thisdate_Ymd]['tempus']."</la><fr>".get_traduction($calendarium[$thisdate_Ymd]['tempus'],"fr",$traductions)."</fr></tempus>";
			$output.="\r\n<hebdomada><la>".$calendarium[$thisdate_Ymd]['hebdomada']."</la><fr>".get_traduction($calendarium[$thisdate_Ymd]['hebdomada'],"fr",$traductions)."</fr></hebdomada>";
			$output.="\r\n<intitule><la>".$calendarium[$thisdate_Ymd]['intitule']."</la><fr>".get_traduction($calendarium[$thisdate_Ymd]['intitule'],"fr",$traductions)."</fr></intitule>";
			$output.="\r\n<rang><la>".$calendarium[$thisdate_Ymd]['rang']."</la><fr>".get_traduction($calendarium[$thisdate_Ymd]['rang'],"fr",$traductions)."</fr></rang>";
			$output.="\r\n<hebdomada_psalterium>".$calendarium[$thisdate_Ymd]['HP']."</hebdomada_psalterium>";
			
			list($MoonPhase, $MoonAge, $MoonDist, $MoonAng, $SunDist, $SunAng, $mpfrac) = Moon::phase(date("Y",$thisdate_ts), date("m",$thisdate_ts), date("d",$thisdate_ts), 00, 00, 01);
			$output.="\r\n<phase_lunaire>".number_format($MoonPhase*100, 2, ',', '')."</phase_lunaire>";
			$output.="\r\n<age_lunaire>".floor($MoonAge)."</age_lunaire>";
			$output.="\r\n<selection>".$selection[$thisdate_Ymd]['intitule']."</selection>";
			

			
/****************************************************************************
 * 
 * ICI l'ALGO qui compile ensemble les formulaires 
 * 
 * 
 ******************************************************************************/
			
			
			$ps=$calendarium[$thisdate_Ymd]['HP'].date("w",$thisdate_ts)+1;
			//print"\r\n ".$ps;
			/// 0 - psautier
			$psautier=simplexml_load_file("sources/psalterium/psalterium_".$ps.".xml");
			
			$liturgia=ajoutexml($liturgia,$psautier);
			$psautier="";
			$jj=date("w",$thisdate_ts)+1;			
			$osb_psalterium=simplexml_load_file("sources/psalterium/psalterium_osb_".$jj.".xml");
			$osb_psalterium="";
			if($osb_psalterium) $liturgia=ajoutexml($liturgia,$osb_psalterium);
			
			/// 1 - férie
			$ferie="";
			if($calendarium[$thisdate_Ymd]['code']) $ferie=@simplexml_load_file("sources/propres/".$calendarium[$thisdate_Ymd]['code'].".xml");
			if($ferie) $liturgia=ajoutexml($liturgia,$ferie);
			$ferie="";
			
			//// 2 - propre
			if($calendarium[$thisdate_Ymd]['propre']) $propre=simplexml_load_file("sources/propres/".$calendarium[$thisdate_Ymd]['propre'].".xml");
			if($propre) $liturgia=ajoutexml($liturgia,$propre);
			
			$propre="";
			
			
			// féries de l'avent / jours au psautier.
			// mktime($hour, $minute, $second, $month, $day, $year, $is_dst)
			$ts_1712=mktime(1,0,0,12,17,$annee);
			$ts_2412=mktime(23,0,0,12,24,$annee);
			if(($thisdate_ts<$ts_2412)&&($thisdate_ts>$ts_1712)&&(date('w',$thisdate_ts)!=0)){
				$jav=date('w',$thisdate_ts)+1;
				$psautier_favent="adventus_".$jav."_ante24";
				$calendarium[$thisdate_Ymd]['favent']=$psautier_favent;
				$calendarium[$thisdate_Ymd]['couleur']="";
				$psav=simplexml_load_file("sources/propres/".$psautier_favent.".xml");
				if($psav) $liturgia=ajoutexml($liturgia,$psav);
				print "\r\n favent = ".$psautier_favent;
			}
			
			
			
			//// 3 - spécial
			$special="";
			//print"\r\n ".$calendarium[$thisdate_Ymd]['special']." -> ";
			if($calendarium[$thisdate_Ymd]['special']) $special=@simplexml_load_file("sources/propres/".@$calendarium[$thisdate_Ymd]['special'].".xml");
			if($special) {
				$liturgia=ajoutexml($liturgia,$special);
				print" special = ".$calendarium[$thisdate_Ymd]['special'];
			}
			$special="";
			
			//// 4 - PLUS
			$plus="";
			if($calendarium[$thisdate_Ymd]['plus']) $plus=@simplexml_load_file("sources/propres/".@$calendarium[$thisdate_Ymd]['plus'].".xml");
			if($plus) {
				$liturgia=ajoutexml($liturgia,$plus);
				print"\r\n plus = ".$calendarium[$thisdate_Ymd]['plus'];
				
			}
			$plus="";
			
			
			if(@$calendarium[$thisdate_Ymd]['1V']=="1") { // Ce sont des secondes vêpres.
				$liturgia['office_soir_la']="Ad II Vesperas";
				$liturgia['intitule_soir_la']=$calendarium[$thisdate_Ymd]['intitule'];
			}
			
			if(
				(@$calendarium[$thisdemain_Ymd]['1V']=="1")
				&&
				($calendarium[$thisdemain_Ymd]['priorite'])
				&&
				($calendarium[$thisdemain_Ymd]['priorite']<$calendarium[$thisdate_Ymd]['priorite'])
			) 
			{ // Il y a des premières vêpres.
				$liturgia['premieresvepres']=1;
				/*
				 * 
				 * TODO : comment gérer correctement ou faut il gérer le psautier des 1ères vêpres ?
				 * 
				 * 
				*/
				 			
				$premV=@simplexml_load_file("sources/propres/".$calendarium[$thisdemain_Ymd]['propre'].".xml");// or die("\r\n ERREUR ! "."sources/propres/".str_replace(" ","_",$tableau['soir']['propre']).".xml");

				if($premV){
					
					if($result=@$premV->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
					if($result=@$premV->xpath('/liturgia/HYMNUS_1V/@id')) $liturgia['HYMNUS_vesperas']=$result[0];
					//print "\r\n debug propre=".$tableau['soir']['propre'];
					if($result=@$premV->xpath('/liturgia/ant01/@id')) $liturgia['ant7']=$result[0];
					
					if($result=@$premV->xpath('/liturgia/ps01/@id')) $liturgia['ps7']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant02/@id')) $liturgia['ant8']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps02/@id')) $liturgia['ps8']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant03/@id')) $liturgia['ant9']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps03/@id')) $liturgia['ps9']=$result[0];
					if($result=@$premV->xpath('/liturgia/LB_1V/@id')) $liturgia['LB_soir']=$result[0];
					if($result=@$premV->xpath('/liturgia/RB_1V/@id')) $liturgia['RB_soir']=$result[0];
					if($result=@$premV->xpath('/liturgia/magnificat_1V/@id')) $liturgia['magnificat']=$result[0];
					//print"\r\n lettre_annee=".$tableau['soir']['lettre_annee'];
					
					if(($calendarium[$thisdemain_Ymd]['lettre_annee']=="A") &&($result=@$premV->xpath('/liturgia/magnificat1_A/@id'))) $liturgia['magnificat']=$result[0];
					if(($calendarium[$thisdemain_Ymd]['lettre_annee']=="B") &&($result=$premV->xpath('/liturgia/magnificat1_B/@id'))) $liturgia['magnificat']=$result[0];
					if(($calendarium[$thisdemain_Ymd]['lettre_annee']=="C") &&($result=@$premV->xpath('/liturgia/magnificat1_C/@id'))) $liturgia['magnificat']=$result[0];
					
					if($result=@$premV->xpath('/liturgia/oratio/@id')) $liturgia['oratio_vesperas']=$result[0];
					if($result=@$premV->xpath('/liturgia/preces/@id')) $liturgia['vepres_preces']=$result[0];
					if($result=@$premV->xpath('/liturgia/HYMNUS_completorium/@id')) $liturgia['HYMNUS_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant10/@id')) $liturgia['ant10']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps10/@id')) $liturgia['ps10']=$result[0];
					if($result=@$premV->xpath('/liturgia/ant11/@id')) $liturgia['ant11']=$result[0];
					if($result=@$premV->xpath('/liturgia/ps11/@id')) $liturgia['ps11']=$result[0];
					if($result=@$premV->xpath('/liturgia/LB_completorium/@id')) $liturgia['LB_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/RB_completorium/@id')) $liturgia['RB_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/oratio_completorium/@id')) $liturgia['oratio_completorium']=$result[0];
					if($result=@$premV->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
					//if(
					$result=@$premV->xpath('/liturgia/rang/la'); $liturgia['rang_soir_la']=$result[0];
					$liturgia['office_soir_la']="Ad I Vesperas";
					// TODO : prévoir l'antienne mariale qui change : Sub tuum praesidium si veille de solennité
					if($liturgia['rang_soir_la']=="Sollemnitas") $liturgia['comp_AM']="AM_Sub_Tuum";
				} 
			}		    
				   
if($parite=="impaire") $ordinal="1";  
else $ordinal="2";

$output.="
\r\n<invitatoire>".$liturgia['ant_invit']."</invitatoire>
\n<HYMNUS_lectures>".$liturgia['HYMNUS_lectures']."</HYMNUS_lectures>
\n<HYMNUS_lec_jour>".$liturgia['HYMNUS_lec_jour']."</HYMNUS_lec_jour>
\n<antL1>".$liturgia['antL1']."</antL1>
\n<psL1>".$liturgia['psL1']."</psL1>
\n<antL2>".$liturgia['antL2']."</antL2>
\n<psL2>".$liturgia['psL2']."</psL2>
\n<antL3>".$liturgia['antL3']."</antL3>
\n<psL3>".$liturgia['psL3']."</psL3>
\n<LVers>".$liturgia['VERS']."</LVers>
n<Llec1>L1_".$messe."</Llec1>
\n<Lrep1>R1_".$messe."</Lrep1>
\n<Llec2>L2_".$messe."</Llec2>
\n<Lrep2>R2_".$messe."</Lrep2>
\n<Loratio id=\"\" />
\n<Levangile id=\"\" />";

// 1er nocturne

if (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['propre']."_NOCT1-".$ordinal.".xml"))
$output.="\n<LEC_NOCT1>".$calendarium[$thisdate_Ymd]['propre']."_NOCT1-".$ordinal."</LEC_NOCT1>";
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['propre']."_NOCT1.xml"))
$output.="\n<LEC_NOCT1>".$calendarium[$thisdate_Ymd]['propre']."_NOCT1</LEC_NOCT1>";
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['code']."-NOCT1-".$ordinal.".xml"))
$output.="\n<LEC_NOCT1>".$calendarium[$thisdate_Ymd]['code']."-NOCT1-".$ordinal."</LEC_NOCT1>";
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['code']."-NOCT1.xml"))
$output.="\n<LEC_NOCT1>".$calendarium[$thisdate_Ymd]['code']."-NOCT1</LEC_NOCT1>";

elseif((1216<date("md",$thisdate_ts))&&(date("md",$thisdate_ts)<1225)){
	if (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/adventus_".date("dm",$thisdate_ts)."-NOCT1-".$ordinal.".xml"))
$output.="\n<LEC_NOCT1>adventus_".date("dm",$thisdate_ts)."-NOCT1-".$ordinal."</LEC_NOCT1>";

}
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['favent']."-NOCT1-".$ordinal.".xml"))
$output.="\n<LEC_NOCT1>".$calendarium[$thisdate_Ymd]['favent']."-NOCT1-".$ordinal."</LEC_NOCT1>";


// 2ème nocturne
if (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['propre']."_NOCT2-".$ordinal.".xml"))
$output.="
\n<LEC_NOCT2>".$calendarium[$thisdate_Ymd]['propre']."_NOCT2-".$ordinal."</LEC_NOCT2>";
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['code']."-NOCT2-".$ordinal.".xml"))
$output.="
\n<LEC_NOCT2>".$calendarium[$thisdate_Ymd]['code']."-NOCT2-".$ordinal."</LEC_NOCT2>";
elseif((1216<date("md",$thisdate_ts))&&(date("md",$thisdate_ts)<1225)){
	if (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/adventus_".date("dm",$thisdate_ts)."-NOCT2-".$ordinal.".xml"))
$output.="\n<LEC_NOCT2>adventus_".date("dm",$thisdate_ts)."-NOCT2-".$ordinal."</LEC_NOCT2>";

}
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['favent']."-NOCT2-".$ordinal.".xml"))
$output.="
\n<LEC_NOCT2>".$calendarium[$thisdate_Ymd]['favent']."-NOCT2-".$ordinal."</LEC_NOCT2>";




//3ème nocturne
if (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['propre']."_NOCT3-".$calendarium[$thisdate_Ymd]['lettre_annee'].".xml"))
$output.="
\n<LEC_NOCT3>".$calendarium[$thisdate_Ymd]['propre']."_NOCT3-".$calendarium[$thisdate_Ymd]['lettre_annee']."</LEC_NOCT3>
";
elseif (file_exists("../societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$calendarium[$thisdate_Ymd]['code']."-NOCT3-".$calendarium[$thisdate_Ymd]['lettre_annee'].".xml"))
$output.="
\n<LEC_NOCT3>".$calendarium[$thisdate_Ymd]['code']."-NOCT3-".$calendarium[$thisdate_Ymd]['lettre_annee']."</LEC_NOCT3>
";




//$liturgia['lettre']
/*
\n<Vant1>".@$liturgia['osb_vig_ant1']."</Vant1>
\n<Vps1>".@$liturgia['osb_vig_ps1']."</Vps1>
\n<Vant2>".@$liturgia['osb_vig_ant2']."</Vant2>
\n<Vps2>".@$liturgia['osb_vig_ps2']."</Vps2>
\n<Vant3>".@$liturgia['osb_vig_ant3']."</Vant3>
\n<Vps3>".@$liturgia['osb_vig_ps3']."</Vps3>
\n<Vant4>".@$liturgia['osb_vig_ant4']."</Vant4>
\n<Vps4>".@$liturgia['osb_vig_ps4']."</Vps4>
\n<Vant5>".@$liturgia['osb_vig_ant5']."</Vant5>
\n<Vps5>".@$liturgia['osb_vig_ps5']."</Vps5>
\n<Vant6>".@$liturgia['osb_vig_ant6']."</Vant6>
\n<Vps6>".@$liturgia['osb_vig_ps6']."</Vps6>

 \n<Vant7>".@$liturgia['osb_vig_ant7']."</Vant7>
 \n<Vps7>".@$liturgia['osb_vig_ps7']."</Vps7>
 \n<Vant8>".@$liturgia['osb_vig_ant8']."</Vant8>
 \n<Vps8>".@$liturgia['osb_vig_ps8']."</Vps8>
 \n<Vant9>".@$liturgia['osb_vig_ant9']."</Vant9>
 \n<Vps9>".@$liturgia['osb_vig_ps9']."</Vps9>
 \n<Vant10>".@$liturgia['osb_vig_ant10']."</Vant10>
 \n<Vps10>".@$liturgia['osb_vig_ps10']."</Vps10>
 \n<Vant11>".@$liturgia['osb_vig_ant11']."</Vant11>
 \n<Vps11>".@$liturgia['osb_vig_ps11']."</Vps11>
 \n<Vant12>".@$liturgia['osb_vig_ant12']."</Vant12>
 \n<Vps12>".@$liturgia['osb_vig_ps12']."</Vps12>

 \n<Vant13>".@$liturgia['osb_vig_ant13']."</Vant13>
 * */
$output.="
 \n<HYMNUS_laudes>".$liturgia['HYMNUS_laudes']."</HYMNUS_laudes>
 \n<ant1>".$liturgia['ant1']."</ant1>
 \n<ps1>".$liturgia['ps1']."</ps1>
 \n<ant2>".$liturgia['ant2']."</ant2>
 \n<ps2>".$liturgia['ps2']."</ps2>
 \n<ant3>".$liturgia['ant3']."</ant3>
 \n<ps3>".$liturgia['ps3']."</ps3>
 \n<LB_matin>".$liturgia['LB_matin']."</LB_matin> 
 \n<RB_matin>".$liturgia['RB_matin']."</RB_matin> ";
if($liturgia['benedictus_A']){ // C'est un dimanche ou une date avec plusieurs A,B,C
$expr="benedictus_".$calendarium[date("Ymd",$thisdate_ts)]['lettre_annee'];
$output.=" \n<benedictus>".$liturgia[$expr]."</benedictus>";
}
else $output.=" \n<benedictus>".$liturgia['benedictus']."</benedictus>";
$output.=" \n<laudes_preces>".$liturgia['laudes_preces']."</laudes_preces>";
if($liturgia['oratio'])	$output.="<oratio_laudes>".$liturgia['oratio']."</oratio_laudes>";
else $output.="<oratio_laudes>".$liturgia['oratio_laudes']."</oratio_laudes>";

$output.="
 
 \n<HYMNUS_3>".$liturgia['HYMNUS_tertiam']."</HYMNUS_3>
 \n<HYMNUS_6>".$liturgia['HYMNUS_sextam']."</HYMNUS_6>
 \n<HYMNUS_9>".$liturgia['HYMNUS_nonam']."</HYMNUS_9>
 
 \n<ant4>".$liturgia['ant4']."</ant4>
 \n<ps4>".$liturgia['ps4']."</ps4>
 \n<ant5>".$liturgia['ant5']."</ant5>
 \n<ps5>".$liturgia['ps5']."</ps5>
 \n<ant6>".$liturgia['ant6']."</ant6>
 \n<ps6>".$liturgia['ps6']."</ps6>
 \n<LB_3>".$liturgia['LB_3']."</LB_3>
 \n<RB_3>".$liturgia['RB_3']."</RB_3>
 \n<LB_6>".$liturgia['LB_6']."</LB_6>
 \n<RB_6>".$liturgia['RB_6']."</RB_6>
 \n<LB_9>".$liturgia['LB_9']."</LB_9>
 \n<RB_9>".$liturgia['RB_9']."</RB_9>
 \n<oratio_3>".$liturgia['oratio_3']."</oratio_3>
 \n<oratio_6>".$liturgia['oratio_6']."</oratio_6>
 \n<oratio_9>".$liturgia['oratio_9']."</oratio_9>";

$output.="
 \n<intitule_soir><la>".$liturgia['intitule_soir_la']."</la></intitule_soir>
 \n<rang_soir><la>".$liturgia['rang_soir_la']."</la></rang_soir>
 \n<office_soir><la>".$liturgia['office_soir_la']."</la></office_soir>
 \n<HYMNUS_vepres>".$liturgia['HYMNUS_vesperas']."</HYMNUS_vepres>
 \n<ant7>".$liturgia['ant7']."</ant7>
 \n<ps7>".$liturgia['ps7']."</ps7>
 \n<ant8>".$liturgia['ant8']."</ant8>
 \n<ps8>".$liturgia['ps8']."</ps8>
 \n<ant9>".$liturgia['ant9']."</ant9>
 \n<ps9>".$liturgia['ps9']."</ps9>
 \n<LB_soir>".$liturgia['LB_soir']."</LB_soir>
 \n<RB_soir>".$liturgia['RB_soir']."</RB_soir>
 \n<magnificat>".$liturgia['magnificat']."</magnificat>
 \n<vepres_preces>".$liturgia['vepres_preces']."</vepres_preces>
 \n<oratio_vepres>".$liturgia['oratio_vesperas']."</oratio_vepres> 
";

/*
 * 
 * COMPLIES
 * 
 * 
 * 
 */
$output.="		
 \n<HYMNUS_complies>".$liturgia['HYMNUS_completorium']."</HYMNUS_complies>
 \n<comp_RB>".$liturgia['RB_completorium']."</comp_RB>";

if (($calendarium[$thisdemain_Ymd]['1V']=="1")&&($liturgia['rang_soir_la']=="Sollemnitas")) { // Complies veille des solennités
	//DEBUG
	//print"\r\n ************************************************";
	//print"\r\n ".$thisdate_Ymd." : Veille de ".$liturgia['rang_soir_la'];
	//print"\r\n ************************************************";
	// FIN DEBUG
	
	$output.="
	 \n<comp_ant1>AN_Miserere_mei_Domine</comp_ant1>
	 \n<comp_ps1>ps4</comp_ps1>
	 \n<comp_ant2>AN_In_noctibus</comp_ant2>
	 \n<comp_ps2>ps133</comp_ps2>
	 \n<comp_LB>LB_Deut_6_4-7</comp_LB>
	 \n<comp_oratio>COL_Visita_quaesumus_Domine_habitationem_istam</comp_oratio>
	";
}
elseif(($calendarium[$thisdate_Ymd]['1V']=="1")&&($liturgia['rang_soir_la']=="Sollemnitas")) { // complies soir des solennités
	
	$output.="
	 \n<comp_ant1>AN_Alis_suis_obumbrabit</comp_ant1>
	 \n<comp_ps1>ps90</comp_ps1>
	 \n<comp_LB>LB_Ap_22_4-5</comp_LB>
	 \n<comp_oratio>COL_Visita_quaesumus_Domine_habitationem_istam</comp_oratio>
	";
	
}

else {

$output.="
 \n<comp_ant1>".$liturgia['ant10']."</comp_ant1>
 \n<comp_ps1>".$liturgia['ps10']."</comp_ps1>";
if($liturgia['ant11']) $output.=" \n<comp_ant2>".$liturgia['ant11']."</comp_ant2>";
$liturgia['ant11']="";
if($liturgia['ps11']) $output.=" \n<comp_ps2>".$liturgia['ps11']."</comp_ps2>";
$liturgia['ps11']="";
$output.=" \n<comp_LB>".$liturgia['LB_completorium']."</comp_LB>
 \r\n<comp_oratio>".$liturgia['oratio_completorium']."</comp_oratio>";

}

// Antiennes mariales après Complies :
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus per annum") $liturgia['comp_AM']="AM_Salve_regina";
	if ($calendarium[$thisdate_Ymd]['code']=="perannum_34-7") $liturgia['comp_AM']="AM_Alma_redemptoris";
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus Adventus") $liturgia['comp_AM']="AM_Alma_redemptoris";
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus Nativitatis") $liturgia['comp_AM']="AM_Alma_redemptoris";
	if(date("m",$thisdate_ts)=="01") $liturgia['comp_AM']="AM_Alma_redemptoris";
	if(date("m",$thisdate_ts)=="02") $liturgia['comp_AM']="AM_Ave_regina_caelorum";
	if(date("m-d",$thisdate_ts)=="02-01") $liturgia['comp_AM']="AM_Alma_redemptoris";
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus Quadragesimae") $liturgia['comp_AM']="AM_Ave_regina_caelorum";
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus passionis") $liturgia['comp_AM']="AM_Ave_regina_caelorum";
	if ($calendarium[$thisdate_Ymd]['tempus']=="Tempus paschale") $liturgia['comp_AM']="AM_Regina_caeli";
	if (($calendarium[$thisdemain_Ymd]['1V']=="1")&&($liturgia['rang_soir_la']=="Sollemnitas")) {
		$liturgia['comp_AM']="AM_Sub_tuum"; 
	}  
	$output.=" \n<comp_AM>".$liturgia['comp_AM']."</comp_AM>";
/*
 * 
 * 
 * MESSE
 * 
 * 
 */
 //$output.="<messe>";
/*
if($calendarium[$thisdate_Ymd]['propre']=="") { // On prend dans le fichier "temporal" + la lettre de l'annee
	$output.="\r\n<messe id=\"".$calendarium[$thisdate_Ymd]['code']."\">";
	$xmlTemporalMesse=simplexml_load_file("temporal_".$calendarium[$thisdate_Ymd]['lettre_annee'].".xml");
	if(@$xmlTemporalMesse->xpath("//".$ref_."//celebration[@id='".$calendarium[$thisdate_Ymd]['code']."']")) 
	{
		$propreMesse = @$xmlTemporalMesse->xpath("//".$ref_."//celebration[@id='".$calendarium[$thisdate_Ymd]['code']."']");
		
	}
}*/
/*
if($calendarium[$thisdate_Ymd]['propre']) {
		$output.="\r\n<messe id=\"".$calendarium[$thisdate_Ymd]['propre']."\">";
			// sanctoral
			//$xmlS = simplexml_load_file("sanctoral_messe.xml");
			GLOBAL $xmlS;
			if(@$xmlS->xpath("//celebration[@id='".$calendarium[$thisdate_Ymd]['propre']."']")) $propreMesse = @$xmlS->xpath("//celebration[@id='".$calendarium[$thisdate_Ymd]['propre']."']");
			//print"\r\n //celebration[@id='".$ref_messe."']";
			
			if($calendarium[$thisdate_Ymd]['propre']) { // priorité au sanctoral
				//$propre=$propreS;
				$lecture1=$calendarium[$thisdate_Ymd]['propre'];
				$lecture2="";
				if(($calendarium[$thisdate_Ymd]['priorite'])&&($calendarium[$thisdate_Ymd]['priorite']<7)) $lecture2=$calendarium[$thisdate_Ymd]['propre'];
				$evangile="EV_".$calendarium[$thisdate_Ymd]['propre'];
				//$output.="\r\n<messe id=\"".$calendarium[$thisdate_Ymd]['propre']."\">";
			}
			if($calendarium[$thisdate_Ymd]['priorite']>6){
					$expr="//celebration[@id='".$calendarium[$thisdate_Ymd]['code']."']//LEC_1_".$parite;
					$lec1=$lst->xpath($expr);
					$lecture1=$lec1[0];
					$lecture2="";
					$expr="//celebration[@id='".$calendarium[$thisdate_Ymd]['code']."']//EV";
					$ev=$lst->xpath($expr);
					$evangile="EV_".$ev[0];
					//$output.="\r\n<messe id=\"".$calendarium[$thisdate_Ymd]['code']."\" >";
				}
			/*
				if($calendarium[$thisdate_Ymd]['priorite']<7){
					$lecture1=$calendarium[$thisdate_Ymd]['code']."_".$calendarium[date("Ymd",$thisdate_ts)]['lettre_annee'];
					$lecture2=$calendarium[$thisdate_Ymd]['code']."_".$calendarium[date("Ymd",$thisdate_ts)]['lettre_annee'];
					$evangile="EV_".$messe."_".$calendarium[date("Ymd",$thisdate_ts)]['lettre_annee'];
				}
			 
				
			
		}*/
		//
		// Propre de la messe dans la neuvaine de Noël !!!! a retirer si ça fonctionne dans "nouveau code de la messe"
		//
		/*
		$adv1217=mktime(1,0,0,12,17,$annee);
		$adv1224=mktime(23,0,0,12,24,$annee);
		$jourdelasemaine=date('N',$thisdate_ts)+1;
		if($jourdelasemaine==8) $jourdelasemaine=1;
		if(($thisdate_ts>$adv1217)&&($thisdate_ts<$adv1224)&&($jourdelasemaine!=1)){		
			//$temporal_xml=@simplexml_load_file("temporal_".$liturgia['lettre'].".xml");
			//$expr="//celebration[@id='adventus_post_1217-".$jourdelasemaine."']";
			//if($temporal_xml) $rr=$temporal_xml->xpath($expr);
			$post1217=simplexml_load_file("sources/propres/adventus_post_1217-".$jourdelasemaine.".xml");
			if($post1217->messe->IN) $liturgia['IN']=$post1217->messe->IN;
			if($post1217->messe->PS1) $liturgia['PS1']=$post1217->messe->PS1;
			if($post1217->messe->PS2) $liturgia['PS2']=$post1217->messe->PS2;
			if($post1217->messe->OF) $liturgia['OF']=$post1217->messe->OF;
			if($post1217->messe->CO) $liturgia['CO']=$post1217->messe->CO;
			if(date("m-d",$thisdate_ts)=="12-19") $liturgia['IN']="IN_Ne_timeas";
			if(date("m-d",$thisdate_ts)=="12-20") {$liturgia['OF']="OF_Ave_Maria";  $liturgia['CO']="CO_Ecce_virgo";}
		}
		
	*/
		
		
/*
$thisproprexml= @simplexml_load_file("sources/propres/".$calendarium[$thisdate_Ymd]['propre'].".xml");
$rp=$thisproprexml->xpath("//messe");
// '/liturgia/RB_osb_vigiles/@id')
/*
 * 
 * 
 * ***** MESSE 
 * 
 */ 
 /*
if($rp) {
	foreach ($rp as $pp) {
		$output.="\r<messe>";
		$output.="\r<Intitule_messe>".$pp->intitule."</Intitule_messe>";
		
		 $TR1=$pp->xpath("TR1[@id]");
		 if($TR1[0]) $output.="\r<TR1>".$TR1[0]['id']."</TR1>";
		 $TR1=$pp->xpath("TR1[@id]");
		 if($TR2[0]) $output.="\r<TR2>".$TR2[0]['id']."</TR2>";
		 $TR3=$pp->xpath("TR3[@id]");
		 if($TR3[0]) $output.="\r<TR3>".$TR3[0]['id']."</TR3>";
		 $TR4=$pp->xpath("TR4[@id]");
		 if($TR4[0]) $output.="\r<TR4>".$TR4[0]['id']."</TR4>";
		 $TR5=$pp->xpath("TR5[@id]");
		 if($TR5[0]) $output.="\r<TR5>".$TR5[0]['id']."</TR5>";
		 $TR6=$pp->xpath("TR6[@id]");
		 if($TR6[0]) $output.="\r<TR6>".$TR6[0]['id']."</TR6>";
		 $TR7=$pp->xpath("TR7[@id]");
		 if($TR7[0]) $output.="\r<TR7>".$TR7[0]['id']."</TR7>";
		
		 
		$IN=$pp->xpath("IN[@id]");
		$output.="\r<IN>".$IN[0]['id']."</IN>";
		
		$COL=$pp->xpath("COL[@id]");
		$output.="\r<COL>".$COL[0]['id']."</COL>";
		
		$LEC=$pp->xpath("LEC[@id]");
		$l=$calendarium[$thisdate_Ymd]['lettre_annee'];
		if($pp->xpath("LEC/".$l."[@id]")) $LEC=$pp->xpath("LEC/".$l."[@id]");
		$output.="\r<LEC1>".$LEC[0]['id']."</LEC1>";
		
		$PS1=$pp->xpath("PS1[@id]");
		if($PS1)$output.="\r<PS1>".$PS1[0]['id']."</PS1>";
		
		$LEC2=$pp->xpath("LEC2[@id]");
		if($pp->xpath("LEC2/".$l."[@id]")) $LEC2=$pp->xpath("LEC2/".$l."[@id]");
		
		if($LEC2[0])$output.="\r<LEC2>".$LEC2[0]['id']."</LEC2>";
		
		$PS2=$pp->xpath("PS2[@id]");
		if($PS2[0])$output.="\r<PS2>".$PS2[0]['id']."</PS2>";
		
		$SEQ=$pp->xpath("SEQ[@id]");
		if($SEQ[0]) $output.="\r<SEQ>".$SEQ[0]['id']."</SEQ>";
		
		$EV=$pp->xpath("EV[@id]");
		if($pp->xpath("EV/".$l."[@id]")) $EV=$pp->xpath("EV/".$l."[@id]");
		
		$output.="\r<EV>".$EV[0]['id']."</EV>";
		
		$OF=$pp->xpath("OF[@id]");
		$output.="\r<OF>".$OF[0]['id']."</OF>";
		
		$SO=$pp->xpath("SO[@id]");
		$output.="\r<SO>".$SO[0]['id']."</SO>";
		
		$CO=$pp->xpath("CO[@id]");
		$output.="\r<CO>".$CO[0]['id']."</CO>";
		
		$PC=$pp->xpath("PC[@id]");
		$output.="\r<PC>PC_".$PC[0]['id']."</PC>";
		
		$output.="\r</messe>";
	}
}
else {
	$output.="<messe>
	\r\n<IN>".$liturgia['IN']."</IN>";
	//if($propre[1]->IN) $output.="<IN>".$propre[1]->IN."</IN>";
	//if($propre[2]->IN) $output.="<IN>".$propre[2]->IN."</IN>";
	$output.="
	\r\n<KY></KY>
	\r\n<GLO></GLO>";
	if($liturgia['oratio'])	$output.="\r\n<COL>".$liturgia['oratio']."</COL>"; // TODO : changer ça : il faut que ce soit la collecte du dimanche qui précèse ou bien, en cas de propre, la collecte propre.
	else $output.="\r\n<COL>".$liturgia['collecte']."</COL>";
	$output.="			
	\r\n<LEC1>".$liturgia['LEC1']."</LEC1>	
	\r\n<PS1>".$liturgia['PS1']."</PS1>
	\r\n<LEC2>".$liturgia['LEC2']."</LEC2>
	\r\n<PS2>".$liturgia['PS2']."</PS2>
	\r\n<SEQ>".$liturgia['SEQ']."</SEQ>
	\r\n<EV>".$liturgia['EV']."</EV>
	\r\n<OF>".$liturgia['OF']."</OF>
	\r\n<SO>".@$liturgia['SO']."</SO>
	\r\n<PREF>".@$liturgia['PREF']."</PREF>
	
	\r\n<CO>".$liturgia['CO']."</CO>
	\r\n<PC>".@$liturgia['PC']."</PC>
	\r\n</messe>\r\n
	";	
}
* */
/* NOUVEAU CODE DE LA MESSE
 * 
 * 
 * */

$thismessexml="";
if($calendarium[$thisdate_Ymd]['propre']) {
	$thismessexml= simplexml_load_file("sources/propres/".$calendarium[$thisdate_Ymd]['propre'].".xml");
	print"\r\n"."sources/propres/".$calendarium[$thisdate_Ymd]['propre'].".xml";
}
if(!$thismessexml->messe){
 $thismessexml= simplexml_load_file("sources/propres/".$calendarium[$thisdate_Ymd]['code'].".xml");
 print"\r\n"."sources/propres/".$calendarium[$thisdate_Ymd]['code'].".xml";
}



		// Propre de la messe dans la neuvaine de Noël 
		//
		$adv1217=mktime(1,0,0,12,17,$annee);
		$adv1224=mktime(23,0,0,12,24,$annee);
		$jourdelasemaine=date('N',$thisdate_ts)+1;
		if($jourdelasemaine==8) $jourdelasemaine=1;
		if(($thisdate_ts>$adv1217)&&($thisdate_ts<$adv1224)&&($jourdelasemaine!=1)){		
			//$temporal_xml=@simplexml_load_file("temporal_".$liturgia['lettre'].".xml");
			//$expr="//celebration[@id='adventus_post_1217-".$jourdelasemaine."']";
			//if($temporal_xml) $rr=$temporal_xml->xpath($expr);
			$thismessexml=simplexml_load_file("sources/propres/adventus_post_1217-".$jourdelasemaine.".xml");
			/*
			if($post1217->messe->IN) $liturgia['IN']=$post1217->messe->IN;
			if($post1217->messe->PS1) $liturgia['PS1']=$post1217->messe->PS1;
			if($post1217->messe->PS2) $liturgia['PS2']=$post1217->messe->PS2;
			if($post1217->messe->OF) $liturgia['OF']=$post1217->messe->OF;
			if($post1217->messe->CO) $liturgia['CO']=$post1217->messe->CO;
			* */
			if(date("m-d",$thisdate_ts)=="12-19") $thismessexml->messe->IN="IN_Ne_timeas";
			if(date("m-d",$thisdate_ts)=="12-20") {$thismessexml->messe->OF="OF_Ave_Maria";  $thismessexml->messe->CO="CO_Ecce_virgo";}
		
		// lectures alignées sur les jours du mois
		$thismessexml2=simplexml_load_file("sources/propres/adventus_".date("dm",$thisdate_ts).".xml");
		//print"\r\n *******************************************\r\n ****************************************\r\n";
		//print_r($thismessexml2);
		$thismessexml->messe->COL['id']=$thismessexml2->messe->COL['id'];
		
		$thismessexml->messe->LEC['id']=$thismessexml2->messe->LEC['id'];
		$thismessexml->messe->PR['id']=$thismessexml2->messe->PR['id'];
		$thismessexml->messe->EV['id']=$thismessexml2->messe->EV['id'];
		//print_r($thismessexml2->messe);
		//print"\r\n *** \r\n";
		//print_r($thismessexml->messe);
		
		}
		
 
$SXEmesse="";
$SXEmesse=$thismessexml->xpath("//messe");
$ABC=$calendarium[$thisdate_Ymd]['lettre_annee'];
//print "\r\n ABC=".$ABC;
foreach ($SXEmesse as $messe) {
		$output.="\r<messe>";
		$output.="\r<Intitule_messe>".$messe->intitule."\r</Intitule_messe>";
		
		$IN=$messe->xpath("IN[@id]");
		foreach ($IN as $item) $output.="\r<IN>".$item['id']."</IN>";
		
		$IN_L=$messe->xpath("IN_L[@id]");
		foreach ($IN_L as $item) $output.="\r<IN_L>".$item['id']."</IN_L>";
		
		$COL=$messe->xpath("COL[@id]");
		foreach ($COL as $item) $output.="\r<COL>".$item['id']."</COL>";
		
		$LEC=$messe->xpath("LEC[@id]");
		foreach ($LEC as $item) $output.="\r<LEC>".$item['id']."</LEC>";
		
		$LEC=$messe->xpath("LEC/".$parite."[@id]");
		foreach ($LEC as $item) $output.="\r<LEC>".$item['id']."</LEC>";
		
		$PR=$messe->xpath("PR[@id]");
		foreach ($PR as $item) $output.="\r<PR>".$item['id']."</PR>";
		
		$PR=$messe->xpath("PR/".$parite."[@id]");
		foreach ($PR as $item) $output.="\r<PR>".$item['id']."</PR>";
		
		$LEC=$messe->xpath("LEC/".$ABC."[@id]");
		foreach ($LEC as $item) $output.="\r<LEC>".$item['id']."</LEC>";
		
		$PS1=$messe->xpath("PS1[@id]");
		foreach ($PS1 as $item) $output.="\r<PS1>".$item['id']."</PS1>";
		
		$LEC2=$messe->xpath("LEC2[@id]");
		foreach ($LEC2 as $item) $output.="<LEC2>".$item['id']."</LEC2>";
		
		$LEC2=$messe->xpath("LEC2/".$ABC."[@id]");
		//print "\r\n"."LEC2/".$ABC."[@id]";
		foreach ($LEC2 as $item) $output.="\r<LEC2>".$item['id']."</LEC2>\r\n";
		
		$PS2=$messe->xpath("PS2[@id]");
		foreach ($PS2 as $item)  $output.="\r<PS2>".$item['id']."</PS2>";
		
		$PS2_L=$messe->xpath("PS2_L[@id]");
		foreach ($PS2_L as $item)  $output.="\r<PS2_L>".$item['id']."</PS2_L>";
		
		$SEQ=$messe->xpath("SEQ[@id]");
		foreach ($SEQ as $item) $output.="\r<SEQ>".$item['id']."</SEQ>";
		
		$EV=$messe->xpath("EV[@id]");
		foreach ($EV as $item) $output.="\r<EV>".$item['id']."</EV>";
		
		$EV=$messe->xpath("EV/".$ABC."[@id]");
		foreach ($EV as $item) $output.="\r<EV>".$item['id']."</EV>";
		
		$OF=$messe->xpath("OF[@id]");
		foreach ($OF as $item) $output.="\r<OF>".$item['id']."</OF>";
		
		$PRE=$messe->xpath("PRE[@id]");
		foreach ($PRE as $item) $output.="\r<PRE>".$item['id']."</PRE>";
		
		$SO=$messe->xpath("SO[@id]");
		foreach ($SO as $item) $output.="\r<SO>".$item['id']."</SO>";
		
		$CO=$messe->xpath("CO[@id]");
		foreach ($CO as $item) $output.="\r<CO>".$item['id']."</CO>";
		
		$CO_L=$messe->xpath("CO_L[@id]");
		foreach ($CO_L as $item) $output.="\r<CO_L>".$item['id']."</CO_L>";
		
		$PC=$messe->xpath("PC[@id]");
		foreach ($PC as $item) $output.="\r<PC>".$item['id']."</PC>";
		
		
		$output.="\r</messe>";
}



			$output.="\r\n</ordo>\r\n";
}


 // Fin génération du jour.
	///$output.="</ordo>";	
	//print "\r\n".$tableau['soir']['ferie'];	
/*
 * TODO : à rétablir pour une mise en prod, après essais :
 * 
 * 	*/	
		$output.=viergemarie($thisdate_ts);
		$output.=jerusalem($thisdate_ts);
		//print "\r\n piété :::::: ".$tableau['matin']['piete'];
		//$output.=pietePopulaire($calendarium[$thisdate_Ymd]['propre'],$calendarium[$thisdate_Ymd]['code'],$calendarium[$thisdate_Ymd]['piete'],$date_courante);
		//$output.="<piete><intitule>".$calendarium[$thisdate_Ymd]['piete']."</intitule></piete>";
		$output.="<piete><intitule>".piete($calendarium[$thisdate_Ymd]['piete'],$thisdate_ts)."</intitule></piete>";
		
		//$output.=calendriercivil($messe,$thisdate_ts);
		//$output.=journeesdediees($messe,$thisdate_ts);
		
		$output.=biographie($thisdate_ts);
		
		$output.="\r\n<martyrologe>";
		$output.=martyrologe($thisdate_ts,$calendarium[$thisdate_Ymd]['code']);
		
		$output.="</martyrologe>\r\n";
		//$output.="\r\n<martyrologe_mobile>".$liturgia['martyrologe']."</martyrologe_mobile>\r\n";
		$output.="\r\n<compendium>".compendium($thisdate_ts)."</compendium>\r\n";	
		$output.="\r\n</calendarium>\r\n";
		//$fichier=fopen('test.xml','w'); 
		//fwrite($fichier,$output); 
		//fclose($fichier); 
		
		$sxe = new SimpleXMLElement($output); // création et formatage du XML
		$sxe->asXML("calendrier/".@date("Y-m-d",$thisdate_ts).".xml"); // sauvegarde du XML
		$sxe->asXML("../societaslaudis/wp-content/plugins/liturgia/LH/calendrier/".@date("Y-m-d",$thisdate_ts).".xml"); // societas laudis site de test
		//print"\r\n calendrier_NEW/".@date("Y-m-d",$thisdate_ts).".xml";
		$thisdate_ts+=60*60*24; // incrémentation jour en timestamp.
	}

	////////////////////////////////////////////////////////////
	////////////// Génération du calendrier mensuel
	////////////////////////////////////////////////////////////
	
	for($p=0;$p<count($cal);$p++) {
		$calendarium=$cal[$p];
	
		$ordo=$calendarium['ordo'];
		$date_courante=mktime(12,0,0,1,1,$annee);
		$dernier_jour=mktime(12,0,0,12,31,$annee);
		$jour=60*60*24;
		while($date_courante <= $dernier_jour) {
			//print"\r\n".date("Y-m-d",$date_courante);
		$mois[$ordo][date('n',$date_courante)].="
		\r\n<jour date=\"".@date("Ymd",$date_courante)."\">
		<intitule>
		<la>".$calendarium[date("Ymd",$date_courante)]['intitule']."</la>
		<fr>".get_traduction($calendarium[date("Ymd",$date_courante)]['intitule'],"fr",$traductions)."</fr>
		</intitule>
		<couleur>".$calendarium[date("Ymd",$date_courante)]['couleur']."</couleur>
		</jour>\r\n";
		
		//print"\r\n ".$calendarium[date("Ymd",$date_courante)]['intitule']." -> ".get_traduction($calendarium[date("Ymd",$date_courante)]['intitule'],"fr",$traductions);
		
		$date_courante+=60*60*24;
		}
	}

	for($b=1;$b<13;$b++) {
		print"\r\n DEBUG annee= ".$annee;
		$content="\r\n<mois>";
		for($p=0;$p<count($cal);$p++) {
			$calendarium=$cal[$p];

			$ordo=$calendarium['ordo'];
			$content.="<ordo id=\"".$ordo."\">";
			$content.=$mois[$ordo][$b];
			$content.="</ordo>";
		}
		$content.="</mois>\r\n";
		
		$sxe = new SimpleXMLElement($content);
		$sxe->asXML("calendrier/".$annee."-".$b.".xml");
		
		$sxe->asXML("../societaslaudis/wp-content/plugins/liturgia/LH/calendrier/".$annee."-".$b.".xml"); // societas laudis site de test
		print"\r\n calendrier/".$annee."-".$b.".xml";
	}
	print"\r\n Fin du script. OKKK";
}


function ajoutexml($liturgia,$xml) {
	
if($xml) {
	
		if($result=@$xml->xpath('/liturgia/martyrologe')) $liturgia['martyrologe']=$result[0];
		else $liturgia['martyrologe']="";
		if($result=@$xml->xpath('/liturgia/ant_invit/@id')) $liturgia['ant_invit']=$result[0];
		if($result=@$xml->xpath('/liturgia/commun/@id')) $liturgia['commun']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_lectures/@id')) $liturgia['HYMNUS_lectures']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_lec_jour/@id')) $liturgia['HYMNUS_lec_jour']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_osb_vigiles/@id')) $liturgia['RB_osb_vigiles']=$result[0];
		if($result=@$xml->xpath('/liturgia/commun/@id')) $liturgia['commun']=$result[0];
		/*
		if($result=@$xml->xpath('/liturgia/osb_vig_ant_attente/@id')) $liturgia['osb_vig_ant_attente']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps_attente/@id')) $liturgia['osb_vig_ps_attente']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps1')) $liturgia['osb_vig_ps1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant1/@id')) $liturgia['osb_vig_ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps2')) $liturgia['osb_vig_ps2']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant2/@id')) $liturgia['osb_vig_ant2']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps3')) $liturgia['osb_vig_ps3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant3/@id')) $liturgia['osb_vig_ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps4')) $liturgia['osb_vig_ps4']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant4/@id')) $liturgia['osb_vig_ant4']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps5')) $liturgia['osb_vig_ps5']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant5/@id')) $liturgia['osb_vig_ant5']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps6')) $liturgia['osb_vig_ps6']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant6/@id')) $liturgia['osb_vig_ant6']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps7')) $liturgia['osb_vig_ps7']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant7/@id')) $liturgia['osb_vig_ant7']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps8')) $liturgia['osb_vig_ps8']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant8/@id')) $liturgia['osb_vig_ant8']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps9')) $liturgia['osb_vig_ps9']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant9/@id')) $liturgia['osb_vig_ant9']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps10')) $liturgia['osb_vig_ps10']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ant10/@id')) $liturgia['osb_vig_ant10']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps11')) $liturgia['osb_vig_ps11']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ps12')) $liturgia['osb_vig_ps12']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_LB/@id')) $liturgia['osb_vig_LB']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers1/@id')) $liturgia['osb_vig_vers1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben1/@id')) $liturgia['osb_vig_ben1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_RB/@id')) $liturgia['osb_vig_RB']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers2/@id')) $liturgia['osb_vig_vers1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben2/@id')) $liturgia['osb_vig_ben1']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_vers3/@id')) $liturgia['osb_vig_vers3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben3/@id')) $liturgia['osb_vig_ben3']=$result[0];
		if($result=@$xml->xpath('/liturgia/osb_vig_ben3/@id')) $liturgia['osb_vig_ben3']=$result[0];
		*/ 
		//$result="";
		if ($result=@$xml->xpath('/liturgia/intitule/la')) $liturgia['intitule_matin_la']=$result[0];
		if($result=@$xml->xpath('/liturgia/antL1/@id')) $liturgia['antL1']=$result[0];
		if($result=@$xml->xpath('/liturgia/psL1/@id')) $liturgia['psL1']=$result[0];
		if($result=@$xml->xpath('/liturgia/antL2/@id')) $liturgia['antL2']=$result[0];
		if($result=@$xml->xpath('/liturgia/psL2/@id')) $liturgia['psL2']=$result[0];
		if($result=@$xml->xpath('/liturgia/antL3/@id')) $liturgia['antL3']=$result[0];
		if($result=@$xml->xpath('/liturgia/psL3/@id')) $liturgia['psL3']=$result[0];
		if($result=@$xml->xpath('/liturgia/VERS/@id')) $liturgia['VERS']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_laudes/@id')) $liturgia['HYMNUS_laudes']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant1/@id')) $liturgia['ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps1/@id')) $liturgia['ps1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant2/@id')) $liturgia['ant2']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant1/@id')) $liturgia['ant1']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps2/@id')) $liturgia['ps2']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant3/@id')) $liturgia['ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps3/@id')) $liturgia['ps3']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant3/@id')) $liturgia['ant3']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_matin/@id')) $liturgia['LB_matin']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_matin/@id')) $liturgia['RB_matin']=$result[0];
		if($result=@$xml->xpath('/liturgia/benedictus/@id')) $liturgia['benedictus']=$result[0];
		 
		if(($liturgia['lettre']=="A") &&($result=@$xml->xpath('/liturgia/benedictus_A/@id'))) $liturgia['benedictus']=$result[0];
		else unset($liturgia['benedictus_A']);
		
		if(($liturgia['lettre']=="B") &&($result=@$xml->xpath('/liturgia/benedictus_B/@id'))) $liturgia['benedictus']=$result[0];
		else unset($liturgia['benedictus_B']);
		
		if(($liturgia['lettre']=="C") &&($result=@$xml->xpath('/liturgia/benedictus_C/@id'))) $liturgia['benedictus']=$result[0];
		else unset($liturgia['benedictus_C']);
		
		if($result=@$xml->xpath('/liturgia/preces/@id')) $liturgia['laudes_preces']=$result[0];
		//else unset($liturgia['laudes_preces']);
		if($result=@$xml->xpath('/liturgia/oratio_laudes/@id')) $liturgia['oratio_laudes']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio/@id')) $liturgia['oratio']=$result[0];
		else unset ($liturgia['oratio']);
		if($result=@$xml->xpath('/liturgia/HYMNUS_tertiam/@id')) $liturgia['HYMNUS_tertiam']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_sextam/@id')) $liturgia['HYMNUS_sextam']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_nonam/@id')) $liturgia['HYMNUS_nonam']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant4/@id')) $liturgia['ant4']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps4/@id')) $liturgia['ps4']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant5/@id')) $liturgia['ant5']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps5/@id')) $liturgia['ps5']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant6/@id')) $liturgia['ant6']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps6/@id')) $liturgia['ps6']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_3/@id')) $liturgia['LB_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_3/@id')) $liturgia['RB_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_3/@id')) $liturgia['oratio_3']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_6/@id')) $liturgia['LB_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_6/@id')) $liturgia['RB_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_6/@id')) $liturgia['oratio_6']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_9/@id')) $liturgia['LB_9']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_9/@id')) $liturgia['RB_9']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_9/@id')) $liturgia['oratio_9']=$result[0];
		//// SOIR
		if($result=@$xml->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
		if($result=@$xml->xpath('/liturgia/rang/la')) $liturgia['rang_soir_la']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_vesperas/@id')) $liturgia['HYMNUS_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant7/@id')) $liturgia['ant7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps7/@id')) $liturgia['ps7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant8/@id')) $liturgia['ant8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps8/@id')) $liturgia['ps8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant9/@id')) $liturgia['ant9']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps9/@id')) $liturgia['ps9']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_soir/@id')) $liturgia['LB_soir']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_soir/@id')) $liturgia['RB_soir']=$result[0];
		//$liturgia['magnificat']="";
		if($result=@$xml->xpath('/liturgia/magnificat/@id')) {
			$liturgia['magnificat']=$result[0];
			}
		
		if(($liturgia['lettre']=="A") &&($result=@$xml->xpath('/liturgia/magnificat_A/@id'))) $liturgia['magnificat']=$result[0];			
		if(($liturgia['lettre']=="B") &&($result=@$xml->xpath('/liturgia/magnificat_B/@id'))) $liturgia['magnificat']=$result[0];			
		if(($liturgia['lettre']=="C") &&($result=@$xml->xpath('/liturgia/magnificat_C/@id'))) $liturgia['magnificat']=$result[0];
					
		if($result=@$xml->xpath('/liturgia/oratio_vesperas/@id')) $liturgia['oratio_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio/@id')) $liturgia['oratio_vesperas']=$result[0]; 
		if($result=@$xml->xpath('/liturgia/preces/@id')) $liturgia['vepres_preces']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_completorium/@id')) $liturgia['HYMNUS_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant10/@id')) $liturgia['ant10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps10/@id')) $liturgia['ps10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant11/@id')) $liturgia['ant11']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps11/@id')) $liturgia['ps11']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_completorium/@id')) $liturgia['LB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_completorium/@id')) $liturgia['RB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_completorium/@id')) $liturgia['oratio_completorium']=$result[0];
		
		
		/****
		//***** Propre  Messe sans les 3 années A B ou C
		if($result=@$xml->xpath('/liturgia/IN/@id')) $liturgia['IN']=$result[0];
		//print"\r\n '/liturgia/IN/@id'  = ".$result[0];
		if($result=@$xml->xpath('/liturgia/PS1/@id')) $liturgia['PS1']=$result[0];
		if($result=@$xml->xpath('/liturgia/PS2/@id')) $liturgia['PS2']=$result[0];
		if($result=@$xml->xpath('/liturgia/SEQ/@id')) $liturgia['SEQ']=$result[0];
		if($result=@$xml->xpath('/liturgia/OF/@id')) $liturgia['OF']=$result[0];
		if($result=@$xml->xpath('/liturgia/CO/@id')) $liturgia['CO']=$result[0];

		// Propre chants Messe A B ou C
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/IN/@id")) $liturgia['IN']=$result[0];
		//print"\r\n /liturgia/anno".$liturgia['lettre']."'/IN/@id'  = "; 
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/PS1/@id")) $liturgia['PS1']=$result[0];
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/PS2/@id")) $liturgia['PS2']=$result[0];
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/SEQ/@id")) $liturgia['SEQ']=$result[0];
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/OF/@id")) $liturgia['OF']=$result[0];
		if($result=@$xml->xpath("/liturgia/anno".$liturgia['lettre']."/CO/@id")) $liturgia['CO']=$result[0];
		
		*/
		//global $annee;
		/*
		// Lectures
		if ($annee%2 == 0) $parite="paire";
			else $parite="impaire";
		//print"\r\n /liturgia/LEC_1_".$parite."/@id'";
		if($result=@$xml->xpath('/liturgia/LEC_1_'.$parite.'/@id')) $liturgia['LEC']=$result[0];
		if($result=@$xml->xpath('/liturgia/LEC_II/'.$liturgia['lettre'].'@id')) $liturgia['LEC_II']=$result[0];
		
		//oraisons messe
		if($result=@$xml->xpath('/liturgia/collecte_temporal/@id')) $liturgia['collecte']=$result[0];
		
		
		//$liturgia['LEC_II']=null;
		//print"\r\n /liturgia/LEC_II/".$liturgia['lettre']."/@id";
		//$result=@$xml->xpath('/liturgia/LEC_II/'.$liturgia['lettre'].'/@id');
		if($result=@$xml->xpath('/liturgia/LEC/'.$liturgia['lettre'].'/@id')) $liturgia['LEC']=$result[0];
		if($result=@$xml->xpath('/liturgia/LEC_II/'.$liturgia['lettre'].'/@id')) $liturgia['LEC_II']=$result[0];
		if($result=@$xml->xpath('/liturgia/EV/'.$liturgia['lettre'].'/@id')) $liturgia['EV']=$result[0];
		// lectures sans les années paires ou impaires.
		if($result=@$xml->xpath('/liturgia/LEC/@id')) $liturgia['LEC']=$result[0];
		if($result=@$xml->xpath('/liturgia/LEC_II/@id')) $liturgia['LEC_II']=$result[0];
		if($result=@$xml->xpath('/liturgia/EV/@id')) $liturgia['EV']=$result[0];
		* */
		
	}
	return $liturgia;
}

/*
function ajoutexml_soir($liturgia,$xml) {
	
	// Le soir
		if($result=@$xml->xpath('/liturgia/intitule/la')) $liturgia['intitule_soir_la']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_vesperas/@id')) $liturgia['HYMNUS_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant7/@id')) $liturgia['ant7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps7/@id')) $liturgia['ps7']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant8/@id')) $liturgia['ant8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps8/@id')) $liturgia['ps8']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant9/@id')) $liturgia['ant9']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps9/@id')) $liturgia['ps9']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_soir/@id')) $liturgia['LB_soir']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_soir/@id')) $liturgia['RB_soir']=$result[0];
		if($result=@$xml->xpath('/liturgia/magnificat/@id')) $liturgia['magnificat']=$result[0];
		//print"\r\n ".$tableau['soir']['lettre_annee'];
		if(($calendarium[date("Ymd",$thisdate_ts)]['lettre_annee']=="A") &&($result=@$xml->xpath('/liturgia/magnificat_A/@id'))) $liturgia['magnificat']=$result[0];
		if(($calendarium[date("Ymd",$thisdate_ts)]['lettre_annee']=="B") &&($result=@$xml->xpath('/liturgia/magnificat_B/@id'))) $liturgia['magnificat']=$result[0];
		if(($calendarium[date("Ymd",$thisdate_ts)]['lettre_annee']=="C") &&($result=@$xml->xpath('/liturgia/magnificat_C/@id'))) $liturgia['magnificat']=$result[0];
		
		if($result=@$xml->xpath('/liturgia/oratio_vesperas/@id')) $liturgia['oratio_vesperas']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio/@id')) $liturgia['oratio_vesperas']=$result[0]; 
		if($result=@$xml->xpath('/liturgia/preces/@id')) $liturgia['vepres_preces']=$result[0];
		if($result=@$xml->xpath('/liturgia/HYMNUS_completorium/@id')) $liturgia['HYMNUS_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant10/@id')) $liturgia['ant10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps10/@id')) $liturgia['ps10']=$result[0];
		if($result=@$xml->xpath('/liturgia/ant11/@id')) $liturgia['ant11']=$result[0];
		if($result=@$xml->xpath('/liturgia/ps11/@id')) $liturgia['ps11']=$result[0];
		if($result=@$xml->xpath('/liturgia/LB_completorium/@id')) $liturgia['LB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/RB_completorium/@id')) $liturgia['RB_completorium']=$result[0];
		if($result=@$xml->xpath('/liturgia/oratio_completorium/@id')) $liturgia['oratio_completorium']=$result[0];
	return $liturgia;
}
*/

?>
