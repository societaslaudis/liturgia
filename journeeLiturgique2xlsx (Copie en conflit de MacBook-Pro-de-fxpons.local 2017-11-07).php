<?php
/********* NOTES
 * proposition d'organisation des répertoires
 * 
 * /textes/ : HY_ AN_ PS AT NT LB_  RB_ COL_ OR_ VERS_ INV_ IN_ GR_ TR_ AL_ SEQ_ OF_ CO_ 
 * /ordo/ psalterium_ perannum_ adventus_ quadragesmima_ pascha_ 



/** PARAMETRES **/
$jourAGenerer="20171218";
/** PHPExcel_IOFactory */
include "PHPExcel/Classes/PHPExcel/IOFactory.php";
/** inclusions des bibliothèques "liturgia" **/
include "societaslaudis/wp-content/plugins//liturgia/LH/fonctions.php";
/****
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
		//$xml=$Fxml->xpath("//ordo[@id='RE']/");
		//print_r($xml);
		$xml=$Fxml;
		print "\r\n ".date('Y-m-d',$date_ts).".xml \r\n \r\n \r\n";
		$i=1;
		print_r($xml->ordo->intitule);
		print $xml->ordo->intitule->la."\r\n";
		print $xml->ordo->intitule->fr."\r\n";
		
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, date('Y-m-d',$date_ts));
		 $i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "intitule"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $xml->ordo->intitule->la);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $xml->ordo->intitule->fr);
		
		/***** INVITATOIRE ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "invitatoire"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->invitatoire); 
		
		$invXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->invitatoire.".xml");
		print $invXML->ligne[0]->la."\r\n";
		print $invXML->ligne[0]->fr."\r\n";
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $invXML->ligne[0]->la); 
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $invXML->ligne[0]->fr); 
		if($invXML->ligne[0]->la=="") $i++;
		
		/**** HYMNE LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_laudes"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->HYMNUS_laudes); 
		
		$HYMNUS_laudesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_laudes.".xml");
		print $HYMNUS_laudesXML->ligne[0]->la."\r\n";
		print $HYMNUS_laudesXML->ligne[0]->fr."\r\n";
		for ($j=0;$j<count($HYMNUS_laudesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $HYMNUS_laudesXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $HYMNUS_laudesXML->ligne[$j]->fr); 
			$i++;
		}
		/**** ANT 1 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant1); 
		$ant1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant1.".xml");
		for ($j=0;$j<count($ant1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant1XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant1XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS1 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps1); 
		$ps1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps1.".xml");
		for ($j=0;$j<count($ps1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps1XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps1XML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** ANT 2 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant2); 
		$ant2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant2.".xml");
		for ($j=0;$j<count($ant2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant2XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant2XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS2 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps2); 
		$ps2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps2.".xml");
		for ($j=0;$j<count($ps2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps2XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps2XML->ligne[$j]->fr); 
			$i++;
		}
		/**** ANT 3 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant3); 
		$ant3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant3.".xml");
		for ($j=0;$j<count($ant3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant3XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant3XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS3 LAUDES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps3"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps3); 
		$ps3XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps3.".xml");
		for ($j=0;$j<count($ps3XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps3XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps3XML->ligne[$j]->fr); 
			$i++;
		}
		
		/****** LB_matin ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_matin"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_matin); 
		$LB_matinXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_matin.".xml");
		for ($j=0;$j<count($LB_matinXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $LB_matinXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $LB_matinXML->ligne[$j]->fr); 
			$i++;
		}
		
		/****** RB_matin ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_matin"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_matin); 
		$RB_matinXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_matin.".xml");
		for ($j=0;$j<count($RB_matinXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $RB_matinXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $RB_matinXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** benedictus ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "benedictus"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->benedictus); 
		$benedictusXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->benedictus.".xml");
		for ($j=0;$j<count($benedictusXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $benedictusXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $benedictusXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** laudes_preces ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "laudes_preces"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "PRECES_".$xml->ordo->laudes_preces."_laudes"); 
		$laudes_precesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/PRECES_".$xml->ordo->laudes_preces."_laudes".".xml");
		for ($j=0;$j<count($laudes_precesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $laudes_precesXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $laudes_precesXML->ligne[$j]->fr); 
			$i++;
		}
		/**** oratio_laudes ***/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_laudes"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_laudes); 
		$oratio_laudesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_laudes.".xml");
		for ($j=0;$j<count($oratio_laudesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $oratio_laudesXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $oratio_laudesXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** INTROIT ********/
		//$i++;
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "IN"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->IN); 
		
		$INXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->IN.".xml");
		
		for ($j=0;$j<count($INXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $INXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $INXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** LEC1 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LEC1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "LEC_".$xml->ordo->messe->LEC1); 
		
		$LEC1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/LEC_".$xml->ordo->messe->LEC1.".xml");
		
		for ($j=0;$j<count($LEC1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $LEC1XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $LEC1XML->ligne[$j]->fr); 
			$i++;
		}
		
		
		/**** PS1 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "PS1"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->PS1); 
		
		$PS1XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->PS1.".xml");
		
		for ($j=0;$j<count($PS1XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $PS1XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $PS1XML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** LEC2 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LEC2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "LEC_".$xml->ordo->messe->LEC1); 
		
		$LEC2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/LEC_".$xml->ordo->messe->LEC2.".xml");
		
		for ($j=0;$j<count($LEC2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $LEC2XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $LEC2XML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** PS2 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "PS2"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->PS2); 
		
		$PS2XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->PS2.".xml");
		
		for ($j=0;$j<count($PS2XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $PS2XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $PS2XML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** SEQ ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "SEQ"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->SEQ); 
		
		$SEQXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->SEQ.".xml");
		
		for ($j=0;$j<count($SEQXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $SEQxml->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $SEQXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** EV ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "EV"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "EV_".$xml->ordo->messe->EV); 
		
		$EVXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/EV_".$xml->ordo->messe->EV.".xml");
		
		for ($j=0;$j<count($EVXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $EVXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $EVXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** OF ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "OF"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->OF); 
		
		$OFXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->OF.".xml");
		
		for ($j=0;$j<count($OFXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $OFXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $OFXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** CO ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "CO"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->messe->CO); 
		
		$COXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->messe->CO.".xml");
		
		for ($j=0;$j<count($COXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $COXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $COXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** HYMNE VEPRES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "HYMNUS_vepres"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->HYMNUS_vepres); 
		
		$HYMNUS_vepresXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->HYMNUS_vepres.".xml");
		
		for ($j=0;$j<count($HYMNUS_vepresXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $HYMNUS_vepresXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $HYMNUS_vepresXML->ligne[$j]->fr); 
			$i++;
		}
		/**** ANT 7 VEPRES ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant7"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant7); 
		$ant7XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant7.".xml");
		for ($j=0;$j<count($ant7XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant7XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant7XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS7  ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps7"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps7); 
		$ps7XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps7.".xml");
		for ($j=0;$j<count($ps7XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps7XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps7XML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** ANT 8 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant8"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant8); 
		$ant8XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant8.".xml");
		for ($j=0;$j<count($ant8XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant8XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant8XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS8  ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps8"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps8); 
		$ps8XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps8.".xml");
		for ($j=0;$j<count($ps8XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps8XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps8XML->ligne[$j]->fr); 
			$i++;
		}
		/**** ANT 9 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ant9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ant9); 
		$ant9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ant9.".xml");
		for ($j=0;$j<count($ant9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ant9XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ant9XML->ligne[$j]->fr); 
			$i++;
		}
		/**** PS9 9 ********/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "ps9"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->ps9); 
		$ps9XML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->ps9.".xml");
		for ($j=0;$j<count($ps9XML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $ps9XML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $ps9XML->ligne[$j]->fr); 
			$i++;
		}
		
		/****** LB_soir ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "LB_soir"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->LB_soir); 
		$LB_soirXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->LB_soir.".xml");
		for ($j=0;$j<count($LB_soirXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $LB_soirXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $LB_soirXML->ligne[$j]->fr); 
			$i++;
		}
		
		/****** RB_soir ****/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "RB_soir"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->RB_soir); 
		$RB_soirXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->RB_soir.".xml");
		for ($j=0;$j<count($RB_soirXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $RB_soirXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $RB_soirXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** magnificat ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "magnificat"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->magnificat); 
		$magnificatXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->magnificat.".xml");
		for ($j=0;$j<count($magnificatXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $magnificatXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $magnificatXML->ligne[$j]->fr); 
			$i++;
		}
		
		/**** vepres_preces ****/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "vepres_preces"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, "PRECES_".$xml->ordo->vepres_preces."_vepres"); 
		$vepres_precesXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/PRECES_".$xml->ordo->vepres_preces."_laudes".".xml");
		for ($j=0;$j<count($vepres_precesXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $vepres_precesXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $vepres_precesXML->ligne[$j]->fr); 
			$i++;
		}
		/**** oratio_vepres ***/
		//$i++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, "oratio_vepres"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $xml->ordo->oratio_vepres); 
		$oratio_vepresXML=simplexml_load_file("societaslaudis/wp-content/plugins/liturgia/LH/TXT/".$xml->ordo->oratio_vepres.".xml");
		for ($j=0;$j<count($oratio_vepresXML->ligne);$j++){
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $oratio_vepresXML->ligne[$j]->la); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $oratio_vepresXML->ligne[$j]->fr); 
			$i++;
		}

// Rename sheet
echo date('H:i:s') . " Rename sheet\n";

$objPHPExcel->getActiveSheet()->setTitle('JourneeLiturgique_'.$jourAGenerer);

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('JourneeLiturgique_'.$jourAGenerer.'.xlsx');

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";

?>
