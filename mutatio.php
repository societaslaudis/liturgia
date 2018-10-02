<?php
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
$dir_nom = 'c:/liturgia/lectures/lect_sanct/';// dossier list� (pour lister le r�pertoir courant : $dir_nom = '.'  --> ('point')

print"\r\n ".$dir_nom;
foreach(glob($dir_nom."*.xml") as $lien) {

echo "\r\n $dir_nom/$lien ";
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