<?php

/** Include path **/
//set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');
/*
include_once "c:/liturgia/fonctions.php";
include_once "c:/liturgia/PHPExcel/Classes/PHPExcel/IOFactory.php";
$inputFileName = "c:/liturgia/lectures/lectures_semaine_temporal.xlsx";
$inputFileType = "Excel2007";
print"Loading file ".pathinfo($inputFileName,PATHINFO_BASENAME)."using IOFactory with a defined reader type of ".$inputFileType."\r\n";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setLoadSheetsOnly("lectures_semaine_temporal");
$objPHPExcel = $objReader->load($inputFileName);
$sheetDataTemporal = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ($sheetDataTemporal as $line) {
	$id=$line['A'];
	$lecturestemporal[$id]['id']=$id;
    $lecturestemporal[$id]['lec1']=$line['B'];
	$lecturestemporal[$id]['pr1']=$line['C'];
	$lecturestemporal[$id]['lec2']=$line['D'];
	$lecturestemporal[$id]['pr2']=$line['E'];
	$lecturestemporal[$id]['EV']=$line['F'];
	//print_r($lecurestemporal[$id]);
}
*/
$xml=simplexml_load_file("sanctoral_messe.xml");

//print_r($xmltemporal_a);
foreach($xml as $ms) {
	//print_r($lec);
		
		//print_r($ms);
		$id=$ms->xpath('@id');
		print"\r\n ".$id[0];
		$aj=@simplexml_load_file("sources/propres/".$id[0].".xml");
		if(!$aj) {
			$contentxml="<liturgia></liturgia>";
			$aj=simplexml_load_string($contentxml);
		}
		
		$IN_=$aj->addChild('IN_');
		$IN_->addAttribute('id', $ms->IN_);
		
		$PS1=$aj->addChild('PS1');
		$PS1->addAttribute('id', $ms->PS1);
		
		$PS2=$aj->addChild('PS2');
		$PS2->addAttribute('id', $ms->PS2);
		
		$SEQ=$aj->addChild('SEQ');
		$SEQ->addAttribute('id', $ms->SEQ);
		
		$OF=$aj->addChild('OF');
		$OF->addAttribute('id', $ms->OF);
		
		$CO=$aj->addChild('CO');
		$CO->addAttribute('id', $ms->CO);
		//$lecimpaire=$aj->addChild('LEC_1_impaire');
		//$lecimpaire->addAttribute('id', $lec['lec1']);
		
		print"  ".$ms->IN_;
		
		
		
		//print_r($aj);
		//print"\r\n";
		print"\r\n asXML(sources/propres/".$id[0].".xml)";
		$aj->asXML("sources/propres/".$id[0].".xml");
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

/*
$dir_nom = 'c:/liturgia/lectures/lect_temp/';// dossier list� (pour lister le r�pertoir courant : $dir_nom = '.'  --> ('point')

print"\r\n ".$dir_nom;
foreach(glob("LEC_*.xml") as $lien) {
//$mois=substr($lien,6,2);
//$jour=substr($lien,7,2);
$xmlfile=simplexml_load_file($lien);
$ttt=str_replace("LEC_","",$lien);
$ttt=str_replace("_A.xml","",$ttt,$count);
if($count>0) $anneeABC="A";
$ttt=str_replace("_B.xml","",$ttt,$count);
if($count>0) $anneeABC="B";
$ttt=str_replace("_C.xml","",$ttt,$count);
if($count>0) $anneeABC="C";
$ttt=str_replace(".xml","",$ttt,$count);
$ref=$xmlfile->xpath("ligne[1]/la");
//print"\r\n ".$ref[0]

$rr=str_replace("Ad Ephesios","Ep",$ref[0]);
$rr=str_replace("Ionas","Jon",$rr);
$rr=str_replace("Iosue","Jos",$rr);
$rr=str_replace("Ioel","Jl",$rr);
$rr=str_replace("Iob","Jb",$rr);
$rr=str_replace("Ephesios","Ep",$rr);
$rr=str_replace("Leviticus","Lv",$rr);
$rr=str_replace("Ad Corinthios I ","1Co",$rr);
$rr=str_replace("Ad Corinthos I","1Co",$rr);
$rr=str_replace("2 Corinthios","2Co",$rr);
$rr=str_replace("1 Corinthios","1Co",$rr);
$rr=str_replace("Ad Corinthios II","2Co",$rr);
$rr=str_replace("Ad Galatas","Ga",$rr);
$rr=str_replace("Ecclesiastes","Qo",$rr);
$rr=str_replace("Ioannis III","3Jn",$rr);
$rr=str_replace("Ioannis II","2Jn",$rr); 
$rr=str_replace("Ioannis I","1Jn",$rr); 
$rr=str_replace("Ioannnis I","1Jn",$rr); 
$rr=str_replace("Ad Ephesios","Ep",$rr);  
$rr=str_replace("De Actus Apostolorum","Ac",$rr); 
$rr=str_replace("Actus Apostolorum","Ac",$rr); 
$rr=str_replace("Actus Apostoorum","Ac",$rr); 
$rr=str_replace("Petri II","2P",$rr); 
$rr=str_replace("Petri I","1P",$rr);  
$rr=str_replace("Perti I","1P",$rr); 
$rr=str_replace("1 Petri","1P",$rr);   
$rr=str_replace("Sapientia","Sg",$rr); 
$rr=str_replace("Sapentia","Sg",$rr); 
$rr=str_replace("Ad Thimotheum II","2Tm",$rr);
$rr=str_replace("Ad Thimotheum I","1Tm",$rr);
$rr=str_replace("Ad Timotheum II","2Tm",$rr);
$rr=str_replace("2 Timotheum","2Tm",$rr);
$rr=str_replace("Ad Timotheum I","1Tm",$rr);
$rr=str_replace("Ad Philemonem","Phm",$rr);
$rr=str_replace("Tobiae","Tb",$rr);
$rr=str_replace("Canticum Canticorum","Ct",$rr);
$rr=str_replace("Ad Philippenses","Ph",$rr);
$rr=str_replace("Isaias","Is",$rr);
$rr=str_replace("Ad Romanos","Rm",$rr);
$rr=str_replace("Ad Hebraeos","He",$rr);
$rr=str_replace("Ad Philippenses","Ph",$rr);
$rr=str_replace("Ad philippenses","Ph",$rr);
$rr=str_replace("Numeri","Nb",$rr);
$rr=str_replace("Apocalypsis","Ap",$rr);
$rr=str_replace("Ad Colossenses","Col",$rr);
$rr=str_replace("Ad Tessalonicenses II","2Th",$rr);
$rr=str_replace("Ad Tessalonicenses I","1Th",$rr);
$rr=str_replace("Ad Thessalonicenses II","2Th",$rr);
$rr=str_replace("ThessII","2Th",$rr);
$rr=str_replace("Ad Thessalonicenses I","1Th",$rr);
$rr=str_replace("AdThessalonicensesI","1Th",$rr);
$rr=str_replace("1 Thessalonicenses","1Th",$rr);
$rr=str_replace("Sophonias","So",$rr);
$rr=str_replace("Machabaeorum II","2Mac",$rr);
$rr=str_replace("Machabaeorum I","1Mac",$rr);
$rr=str_replace("Macchabeorum II","2Mac",$rr);
$rr=str_replace("Macchabeorum I","1Mac",$rr);
$rr=str_replace("Ezechiel","Ez",$rr);
$rr=str_replace("Regum II","2R",$rr);
$rr=str_replace("Regum I","1R",$rr);
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
$rr=str_replace("Ad Titum","Tt",$rr);
$rr=str_replace("Nehemiae","Ne",$rr);
$rr=str_replace("Habacuc","Ha",$rr);
$rr=str_replace("Amos","Am",$rr);
$rr=str_replace(":","",$rr);
 
$rr=str_replace("Matthaeus","Mt",$rr);
 $rr=str_replace("Luc","Lc",$rr);
$rr=str_replace("Marcus","Mc",$rr);
$rr=str_replace("Ioannes","Jn",$rr);
$rr=str_replace("Io","Jn",$rr);

$rr=str_replace(" ","",$rr);
$rr=str_replace("AdThessalonicensesI","1Th",$rr);
$rr=str_replace("(","",$rr);
$rr=str_replace(")","",$rr);
$rr=trim($rr);

echo "\r\n $lien -> ".$ttt." ".$anneeABC." -> ".$rr;
$temporalxmlfile=simplexml_load_file("C:/liturgia/sources/propres/".no_accent($ttt).".xml");
if(!$temporalxmlfile) {
	$xmlcontent="<liturgia></liturgia>";
	$temporalxmlfile=simplexml_load_string($xmlcontent);
}

//unset($temporalxmlfile->EV);

/*
$lec=$temporalxmlfile->LEC;
if(!$lec) $temporalxmlfile->addChild("LEC");
$lecannee=$lec->xpath($anneeABC);
if(!$lecannee) $lecannee=$lec->addChild($anneeABC);
$lecannee->addAttribute("id",trim($rr));
*/
//$temporalxmlfile->asXML("c:/liturgia/sources/propres/".no_accent($ttt).".xml");
//$xmlfile->asXML("c:/liturgia/lectures/lec_temp/LEC_".trim($rr).".xml");


 
///////////// ICI le code pour le traitement des fichiers xml d'evangile
//if ((substr($lien,0,2)=="EV")||(substr($lien,0,2)=="HY")) hy2xml($lien);
//print"<br>".$lien -> XML;
//echo "</ul>";

//}
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