<?php

/** PARAMETRES **/
//$jourAGenerer="20181203";
/** PHPExcel_IOFactory */
include "PHPExcel/Classes/PHPExcel/IOFactory.php";
/** inclusions des bibliothèques "liturgia" **/
include "societaslaudis/wp-content/plugins//liturgia/LH/fonctions.php";

 journeeLiturgique2xlsx(20180913);
 function journeeLiturgique2xlsx($jourAGenerer){
 
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
$objPHPExcel->getProperties()->setTitle("Journée liturgique : ".$jourAGenerer);
$objPHPExcel->getProperties()->setSubject("Journée liturgique : ".$jourAGenerer);
$objPHPExcel->getProperties()->setDescription("Journée liturgique : ".$jourAGenerer.", generated using PHP classes.");


// Add some data
echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$date_ts=date2dateTS($jourAGenerer);


//$tab_jour = array(1 => 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');

		
		$Fxml=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/calendrier/".date('Y-m-d',$date_ts).".xml");
		$Sxml=$Fxml->xpath("ordo[@id='RE']");
		//print_r($Sxml);
		$xml=$Fxml;
		//print "\r\n ".date('Y-m-d',$date_ts).".xml \r\n \r\n \r\n";
		$i=1;
		//print_r($xml->ordo->intitule);
		//print $xml->ordo->intitule->la."\r\n";
		//print $xml->ordo->intitule->fr."\r\n";
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, date('Y-m-d',$date_ts));
		 $i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "intitule"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($xml->ordo->intitule->la));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($xml->ordo->intitule->fr));
		
		/***** INVITATOIRE ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "invitatoire"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->invitatoire)); 
		
		$invXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->invitatoire.".xml");
		//print $invXML->ligne[0]->la."\r\n";
		//print $invXML->ligne[0]->fr."\r\n";
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($invXML->ligne[0]->la)); 
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($invXML->ligne[0]->fr)); 
		if($invXML->ligne[0]->la=="") $i++;
		
		/**** HYMNE LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_laudes"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->HYMNUS_laudes)); 
		
		$HYMNUS_laudesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_laudes.".xml");
		for ($j=0;$j<count($HYMNUS_laudesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($HYMNUS_laudesXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($HYMNUS_laudesXML->ligne[$j]->fr)); 
			$i++;
		}
		if($HYMNUS_laudesXML->ligne[0]->la=="") $i++;
		/**** ANT 1 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->ant1)); 
		$ant1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant1.".xml");
		for ($j=0;$j<count($ant1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant1XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant1XML->ligne[$j]->fr)); 
			$i++;
		}
		if($$ant1XML->ligne[0]->la=="") $i++;
		/**** PS1 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->ps1)); 
		$ps1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps1.".xml");
		for ($j=0;$j<count($ps1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps1XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps1XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps1XML->ligne[0]->la=="") $i++;
		/**** ANT 2 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->ant2)); 
		$ant2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant2.".xml");
		for ($j=0;$j<count($ant2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant2XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant2XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant2XML->ligne[0]->la=="") $i++;
		/**** PS2 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps2); 
		$ps2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps2.".xml");
		for ($j=0;$j<count($ps2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps2XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps2XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps2XML->ligne[0]->la=="") $i++;
		/**** ANT 3 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant3); 
		$ant3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant3.".xml");
		for ($j=0;$j<count($ant3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant3XML->ligne[0]->la=="") $i++;
		/**** PS3 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->ps3)); 
		$ps3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps3.".xml");
		for ($j=0;$j<count($ps3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps3XML->ligne[0]->la=="") $i++;
		/****** LB_matin ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_matin"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->LB_matin)); 
		$LB_matinXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_matin.".xml");
		for ($j=0;$j<count($LB_matinXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LB_matinXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LB_matinXML->ligne[$j]->fr)); 
			$i++;
		}
		if($LB_matinXML->ligne[0]->la=="") $i++;
		/****** RB_matin ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_matin"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->RB_matin)); 
		$RB_matinXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_matin.".xml");
		for ($j=0;$j<count($RB_matinXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($RB_matinXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($RB_matinXML->ligne[$j]->fr)); 
			$i++;
		}
		if($RB_matinXML->ligne[0]->la=="") $i++;
		/**** benedictus ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "benedictus"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->benedictus)); 
		$benedictusXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->benedictus.".xml");
		for ($j=0;$j<count($benedictusXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($benedictusXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($benedictusXML->ligne[$j]->fr)); 
			$i++;
		}
		if($benedictusXML->ligne[0]->la=="") $i++;
		/**** laudes_preces ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "laudes_preces"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "PRECES_".$xml->ordo->laudes_preces."_laudes"); 
		$laudes_precesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/PRECES_".$xml->ordo->laudes_preces."_laudes".".xml");
		for ($j=0;$j<count($laudes_precesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($laudes_precesXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($laudes_precesXML->ligne[$j]->fr)); 
			$i++;
		}
		if($laudes_precesXML->ligne[0]->la=="") $i++;
		/**** oratio_laudes ***/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_laudes"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->oratio_laudes)); 
		$oratio_laudesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_laudes.".xml");
		for ($j=0;$j<count($oratio_laudesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($oratio_laudesXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($oratio_laudesXML->ligne[$j]->fr)); 
			$i++;
		}
		if($oratio_laudesXML->ligne[0]->la=="") $i++;
		
		
		
		/***** TIERCE - SEXTE - NONE *********/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->HYMNUS_3)); 
		$HYMNUS_3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_3.".xml");
		for ($j=0;$j<count($HYMNUS_3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($HYMNUS_3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($HYMNUS_3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($HYMNUS_3XML->ligne[0]->la=="") $i++;
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->HYMNUS_6));
		$HYMNUS_6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_6.".xml");
		for ($j=0;$j<count($HYMNUS_6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($HYMNUS_6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($HYMNUS_6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($HYMNUS_6XML->ligne[0]->la=="") $i++;
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->HYMNUS_9));
		$HYMNUS_9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_9.".xml");
		for ($j=0;$j<count($HYMNUS_9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($HYMNUS_9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($HYMNUS_9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($HYMNUS_9XML->ligne[0]->la=="") $i++;
		
		//ant4
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant4"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, trim($xml->ordo->ant4));
		$ant4XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant4.".xml");
		for ($j=0;$j<count($ant4XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant4XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant4XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant4XML->ligne[0]->la=="") $i++;
		
		
		
		//ps4
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps4"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps4);
		$ps4XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps4.".xml");
		for ($j=0;$j<count($ps4XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps4XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps4XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps4XML->ligne[0]->la=="") $i++;
		
		//ant5
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant5"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant5);
		$ant5XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant5.".xml");
		for ($j=0;$j<count($ant5XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant5XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant5XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant5XML->ligne[0]->la=="") $i++;
				
		//ps5
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps5"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps5);
		$ps5XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps5.".xml");
		for ($j=0;$j<count($ps5XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps5XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps5XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps5XML->ligne[0]->la=="") $i++;
			
		
		//ant6
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant6);
		$ant6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant6.".xml");
		for ($j=0;$j<count($ant6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant6XML->ligne[0]->la=="") $i++;
		
		
		//ps6
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps6);
		$ps6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps6.".xml");
		for ($j=0;$j<count($ps6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps6XML->ligne[0]->la=="") $i++;
		
		//LB_3
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_3);
		$LB_3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_3.".xml");
		for ($j=0;$j<count($LB_3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LB_3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LB_3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($LB_3XML->ligne[0]->la=="") $i++;
		
		//RB_3
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_3);
		$RB_3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_3.".xml");
		for ($j=0;$j<count($RB_3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($RB_3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($RB_3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($RB_3XML->ligne[0]->la=="") $i++;
		//LB_6
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_6);
		$LB_6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_6.".xml");
		for ($j=0;$j<count($LB_6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LB_6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LB_6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($LB_6XML->ligne[0]->la=="") $i++;
		//RB_6
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_6);
		$RB_6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_6.".xml");
		for ($j=0;$j<count($RB_6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($RB_6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($RB_6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($RB_6XML->ligne[0]->la=="") $i++;
		//LB_9
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_9);
		$LB_9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_9.".xml");
		for ($j=0;$j<count($LB_9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LB_9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LB_9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($LB_9XML->ligne[0]->la=="") $i++;
		//RB_9
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_9);
		$RB_9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_9.".xml");
		for ($j=0;$j<count($RB_9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($RB_9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($RB_9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($RB_9XML->ligne[0]->la=="") $i++;
		//oratio_3
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_3);
		$oratio_3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_3.".xml");
		for ($j=0;$j<count($oratio_3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($oratio_3XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($oratio_3XML->ligne[$j]->fr)); 
			$i++;
		}
		if($oratio_3XML->ligne[0]->la=="") $i++;
		
		//oratio_6
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_6"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_6);
		$oratio_6XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_6.".xml");
		for ($j=0;$j<count($oratio_6XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($oratio_6XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($oratio_6XML->ligne[$j]->fr)); 
			$i++;
		}
		if($oratio_6XML->ligne[0]->la=="") $i++;
		//oratio_9
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_9);
		$oratio_9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_9.".xml");
		for ($j=0;$j<count($oratio_9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($oratio_9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($oratio_9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($oratio_9XML->ligne[0]->la=="") $i++;
		/**** INTROIT ********/
		//$i++;
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "IN"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->IN); 
		
		$INXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->IN.".xml");
		
		for ($j=0;$j<count($INXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($INXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($INXML->ligne[$j]->fr)); 
			$i++;
		}
		if($INXML->ligne[0]->la=="") $i++;
		/**** LEC ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LEC"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->LEC); 
		print"\r\n ************************** \r\n societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->LEC.".xml";
		$LEC1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->LEC.".xml");
		
		for ($j=0;$j<count($LEC1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LEC1XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LEC1XML->ligne[$j]->fr)); 
			$i++;
		}
		if($LEC1XML->ligne[0]->la=="") $i++;
		
		/**** PS1 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "PS1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->PS1); 
		
		$PS1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->PS1.".xml");
		
		for ($j=0;$j<count($PS1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($PS1XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($PS1XML->ligne[$j]->fr)); 
			$i++;
		}
		if($PS1XML->ligne[0]->la=="") $i++;
		/**** LEC2 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LEC2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->LEC2); 
		
		if($xml->ordo->messe->LEC2) $LEC2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->LEC2.".xml");
		
		for ($j=0;$j<count($LEC2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LEC2XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LEC2XML->ligne[$j]->fr)); 
			$i++;
		}
		if($LEC2XML->ligne[0]->la=="") $i++;
		/**** PS2 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "PS2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->PS2); 
		
		if($xml->ordo->messe->PS2) $PS2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->PS2.".xml");
		
		for ($j=0;$j<count($PS2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($PS2XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($PS2XML->ligne[$j]->fr)); 
			$i++;
		}
		if($PS2XML->ligne[0]->la=="") $i++;
		/**** SEQ ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "SEQ"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->SEQ); 
		
		if($xml->ordo->messe->SEQ) $SEQXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->SEQ.".xml");
		
		for ($j=0;$j<count($SEQXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($SEQxml->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($SEQXML->ligne[$j]->fr)); 
			$i++;
		}
		if($SEQXML->ligne[0]->la=="") $i++;
		/**** EV ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "EV"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->EV); 
		
		$EVXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->EV.".xml");
		
		for ($j=0;$j<count($EVXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($EVXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($EVXML->ligne[$j]->fr)); 
			$i++;
		}
		if($EVXML->ligne[0]->la=="") $i++;
		/**** OF ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "OF"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->OF); 
		
		$OFXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->OF.".xml");
		
		for ($j=0;$j<count($OFXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($OFXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($OFXML->ligne[$j]->fr)); 
			$i++;
		}
		if($OFXML->ligne[0]->la=="") $i++;
		/**** CO ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "CO"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->CO); 
		
		$COXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->CO.".xml");
		
		for ($j=0;$j<count($COXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($COXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($COXML->ligne[$j]->fr)); 
			$i++;
		}
		if($COXML->ligne[0]->la=="") $i++;
		
				
		/**** HYMNE VEPRES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_vepres"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->HYMNUS_vepres); 
		
		$HYMNUS_vepresXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_vepres.".xml");
		
		for ($j=0;$j<count($HYMNUS_vepresXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($HYMNUS_vepresXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($HYMNUS_vepresXML->ligne[$j]->fr)); 
			$i++;
		}
		if($HYMNUS_vepresXML->ligne[0]->la=="") $i++;
		/**** ANT 7 VEPRES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant7"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant7); 
		$ant7XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant7.".xml");
		for ($j=0;$j<count($ant7XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant7XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant7XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant7XML->ligne[0]->la=="") $i++;
		/**** PS7  ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps7"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps7); 
		$ps7XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps7.".xml");
		for ($j=0;$j<count($ps7XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps7XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps7XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps7XML->ligne[0]->la=="") $i++;
		/**** ANT 8 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant8"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant8); 
		$ant8XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant8.".xml");
		for ($j=0;$j<count($ant8XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant8XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant8XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant8XML->ligne[0]->la=="") $i++;
		/**** PS8  ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps8"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps8); 
		$ps8XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps8.".xml");
		for ($j=0;$j<count($ps8XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps8XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps8XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps8XML->ligne[0]->la=="") $i++;
		/**** ANT 9 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant9); 
		$ant9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant9.".xml");
		for ($j=0;$j<count($ant9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ant9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ant9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ant9XML->ligne[0]->la=="") $i++;
		/**** PS9 9 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps9); 
		$ps9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps9.".xml");
		for ($j=0;$j<count($ps9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($ps9XML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($ps9XML->ligne[$j]->fr)); 
			$i++;
		}
		if($ps9XML->ligne[0]->la=="") $i++;
		/****** LB_soir ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_soir"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_soir); 
		$LB_soirXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_soir.".xml");
		for ($j=0;$j<count($LB_soirXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($LB_soirXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($LB_soirXML->ligne[$j]->fr)); 
			$i++;
		}
		if($LB_soirXML->ligne[0]->la=="") $i++;
		/****** RB_soir ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_soir"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_soir); 
		$RB_soirXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_soir.".xml");
		for ($j=0;$j<count($RB_soirXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($RB_soirXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($RB_soirXML->ligne[$j]->fr)); 
			$i++;
		}
		if($RB_soirXML->ligne[0]->la=="") $i++;
		/**** magnificat ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "magnificat"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->magnificat); 
		$magnificatXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->magnificat.".xml");
		for ($j=0;$j<count($magnificatXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($magnificatXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($magnificatXML->ligne[$j]->fr)); 
			$i++;
		}
		if($magnificatXML->ligne[0]->la=="") $i++;
		/**** vepres_preces ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "vepres_preces"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "PRECES_".$xml->ordo->vepres_preces."_vepres"); 
		$vepres_precesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/PRECES_".$xml->ordo->vepres_preces."_laudes".".xml");
		for ($j=0;$j<count($vepres_precesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($vepres_precesXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($vepres_precesXML->ligne[$j]->fr)); 
			$i++;
		}
		if($vepres_precesXML->ligne[0]->la=="") $i++;
		/**** oratio_vepres ***/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_vepres"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_vepres); 
		$oratio_vepresXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_vepres.".xml");
		for ($j=0;$j<count($oratio_vepresXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, trim($oratio_vepresXML->ligne[$j]->la)); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, trim($oratio_vepresXML->ligne[$j]->fr)); 
			$i++;
		}
		if($oratio_vepresXML->ligne[0]->la=="") $i++;
		
		///**** COMPLIES *****///
		
		
		
		
// Rename sheet
echo date('H:i:s') . " Rename sheet\n";

$objPHPExcel->getActiveSheet()->setTitle('JourneeLiturgique_'.$jourAGenerer);

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('corrections_en_cours/JourneeLiturgique_'.$jourAGenerer.'.xlsx');

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
}

?>
