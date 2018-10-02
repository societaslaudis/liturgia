<?php

/** Include path **/
//set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');
include_once "c:/liturgia/fonctions.php";
include_once "c:/liturgia/PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "W:/calendrier_RE.xlsx";
$inputFileType = "Excel2007";
print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("Cal général Romain");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataSanctoral = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetDataSanctoral as $line) {
	$date_sanctoral=@mktime(12,0,0,$line['A'],$line['D']);
    $dds=date("m-d", $date_sanctoral);
    $intitule_sanctoral[$dds]=$line['E'];
}



/*
    $temporal_c=simplexml_load_file("temporal_c.xml");
	foreach($temporal_c as $temp) {
		$r=$temp->xpath("@id");
		$propre_aj=@simplexml_load_file("sources/propres/".$r[0].".xml");
		if($propre_aj){
		$anno=$propre_aj->addChild('annoC');
		$IN_=$anno->addChild('IN_');
		$IN_->addAttribute('id', $temp->IN_[0]);
		
		$PS1=$anno->addChild('PS1');
		$PS1->addAttribute('id', $temp->PS1[0]);
		
		$PS2=$anno->addChild('PS2');
		$PS2->addAttribute('id', $temp->PS2[0]);
		
		$OF=$anno->addChild('OF');
		$OF->addAttribute('id', $temp->OF[0]);
		
		$CO=$anno->addChild('CO');
		$CO->addAttribute('id', $temp->CO[0]);
		
		
		//print"\r\n ".$temp['IN_'];
		$propre_aj->asXML("sources/propres/".$r[0].".xml");
		}
	}
	*/
/*	
	
	    $lecturessemaine=simplexml_load_file("lectures_semaine_temporal.xml");
	foreach($lecturessemaine as $lec) {
		$r=$lec->xpath("@id");
		$aj=@simplexml_load_file("sources/propres/".$r[0].".xml");
		if($aj){
		$lecimpaire=$aj->addChild('LEC_1_impaire');
		$lecimpaire->addAttribute('id', $lec->LEC_1_impaire[0]);
		
		$primpaire=$aj->addChild('PR_impaire');
		$primpaire->addAttribute('id', $lec->PR_impaire[0]);
		
		$lecpaire=$aj->addChild('LEC_1_paire');
		$lecpaire->addAttribute('id', $lec->LEC_1_paire[0]);
		
		$prpaire=$aj->addChild('PR_paire');
		$prpaire->addAttribute('id', $lec->PR_paire[0]);
		
		$EV=$aj->addChild('EV');
		$EV->addAttribute('id', $lec->EV[0]);
		
		//print"\r\n ".$temp['IN_'];
		$aj->asXML("sources/propres/".$r[0].".xml");
		}
	}
*/	
$dir_nom = 'c:/liturgia/lectures/lect_temp/';// dossier list� (pour lister le r�pertoir courant : $dir_nom = '.'  --> ('point')

print"\r\n ".$dir_nom;
foreach(glob("LEC_*.xml") as $lien) {
$mois=substr($lien,4,2);
$jour=substr($lien,7,2);
$xmlfile=simplexml_load_file($lien);
$ref=$xmlfile->xpath("ligne[1]/la");
//print"\r\n ".$ref[0]

$rr=str_replace("Ad Ephesios","Ep",$ref[0]);
$rr=str_replace("Ad Corinthios I ","1Co",$rr);
$rr=str_replace("Ad Corinthios II","2Co",$rr);
$rr=str_replace("Ad Galatas","Ga",$rr);
$rr=str_replace("Ioannis III","3Jn",$rr);
$rr=str_replace("Ioannis II","2Jn",$rr); 
$rr=str_replace("Ioannis I ","1Jn",$rr); 
$rr=str_replace("Ad Ephesios","Ep",$rr);  
$rr=str_replace("Actus Apostolorum","Ac",$rr); 
$rr=str_replace("Petri II","2P",$rr); 
$rr=str_replace("Petri I","1P",$rr);  
$rr=str_replace("Sapientia","Sg",$rr); 
$rr=str_replace("Sapentia","Sg",$rr); 
$rr=str_replace("Ad Thimotheum II","2Tm",$rr);
$rr=str_replace("Ad Thimotheum I","1Tm",$rr);
$rr=str_replace("Ad Timotheum II","2Tm",$rr);
$rr=str_replace("Ad Timotheum I","1Tm",$rr);
$rr=str_replace("Tobiae","Tb",$rr);
$rr=str_replace("Canticum Canticorum","Ct",$rr);
$rr=str_replace("Ad Philippenses","Ph",$rr);
$rr=str_replace("Isaias","Is",$rr);
$rr=str_replace("Ad Romanos","Rm",$rr);
$rr=str_replace("Ad Hebraeos","He",$rr);
$rr=str_replace("Numeri","Nb",$rr);
$rr=str_replace("Apocalypsis","Ap",$rr);
$rr=str_replace("Ad Colossenses","Col",$rr);
$rr=str_replace("Ad Tessalonicenses II","2Th",$rr);
$rr=str_replace("Ad Tessalonicenses I","1Th",$rr);
$rr=str_replace("Ad Thessalonicenses II","2Th",$rr);
$rr=str_replace("Ad Thessalonicenses I","1Th",$rr);
$rr=str_replace("Sophonias","So",$rr);
$rr=str_replace("Machabaeorum II","2Mac",$rr);
$rr=str_replace("Machabaeorum I","1Mac",$rr);
$rr=str_replace("Macchabeorum II","2Mac",$rr);
$rr=str_replace("Macchabeorum I","1Mac",$rr);
$rr=str_replace("Ezechiel","Ez",$rr);
$rr=str_replace("Proverbia","Pr",$rr);
$rr=str_replace("Ecclesiasticus","Sir",$rr);
$rr=str_replace("Daniel","Dn",$rr);
$rr=str_replace("Deuteronomium","Dt",$rr);
$rr=str_replace("Paralipomenon II","2Par",$rr);
$rr=str_replace("Paralipomenon I","1Par",$rr);
$rr=str_replace("Isaias","Is",$rr);
$rr=str_replace("Michaea","Mic",$rr);
$rr=str_replace("Ad Haebreos","He",$rr);
$rr=str_replace("Exodus","Ex",$rr);
$rr=str_replace("Zacharias","Za",$rr);
$rr=str_replace("Genesis","Gn",$rr);
$rr=str_replace("Iacobi","Jc",$rr);
$rr=str_replace("Osee","Os",$rr);
$rr=str_replace("Ieremias","Jr",$rr);
$rr=str_replace("Malachias","Ml",$rr);
$rr=str_replace(":","",$rr);
 /*
$rr=str_replace("Luc","Lc",$rr);
$rr=str_replace("Marcus","Mc",$rr);
$rr=str_replace("Ioannes","Jn",$rr);
$rr=str_replace("Io","Jn",$rr);
*/
$rr=str_replace(" ","",$rr);

$rr=str_replace("(","",$rr);
$rr=str_replace(")","",$rr);
$rr=trim($rr);

echo "\r\n $lien -> ".$mois." ".$jour." -> ".$rr." ".no_accent($intitule_sanctoral[$mois."-".$jour]);
$sanctoralxmlfile=simplexml_load_file("C:/liturgia/sources/propres/".no_accent($intitule_sanctoral[$mois."-".$jour]).".xml");
if(!$sanctoralxmlfile) {
	$xmlcontent="<liturgia></liturgia>";
	$sanctoralxmlfile=simplexml_load_string($xmlcontent);
}

unset($sanctoralxmlfile->LEC);


$ev=$sanctoralxmlfile->addChild("LEC");
$ev->addAttribute("id",trim($rr));

//$sanctoralxmlfile->asXML("c:/liturgia/sources/propres/".no_accent($intitule_sanctoral[$mois."-".$jour]).".xml");
//$xmlfile->asXML("c:/liturgia/lectures/lec_sanct/LEC_".$rr.".xml");


 
///////////// ICI le code pour le traitement des fichiers xml d'evangile
//if ((substr($lien,0,2)=="EV")||(substr($lien,0,2)=="HY")) hy2xml($lien);
//print"<br>".$lien -> XML;
//echo "</ul>";

}
/*
	$lecturessemaine=simplexml_load_file("lectures_semaine_temporal.xml");
	foreach($lecturessemaine as $lec) {
		$r=$lec->xpath("@id");
		$aj=@simplexml_load_file("sources/propres/".$r[0].".xml");
		if($aj){
		$lecimpaire=$aj->addChild('LEC_1_impaire');
		$lecimpaire->addAttribute('id', $lec->LEC_1_impaire[0]);
		
		$primpaire=$aj->addChild('PR_impaire');
		$primpaire->addAttribute('id', $lec->PR_impaire[0]);
		
		$lecpaire=$aj->addChild('LEC_1_paire');
		$lecpaire->addAttribute('id', $lec->LEC_1_paire[0]);
		
		$prpaire=$aj->addChild('PR_paire');
		$prpaire->addAttribute('id', $lec->PR_paire[0]);
		
		$EV=$aj->addChild('EV');
		$EV->addAttribute('id', $lec->EV[0]);
		
		//print"\r\n ".$temp['IN_'];
		$aj->asXML("sources/propres/".$r[0].".xml");
		}
	}
*/
	
?>