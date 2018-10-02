<?php 
// Include the PHPWord.php, all other classes were loaded by an autoloader
require_once 'PHPWord.php';
global $table;
global $PHPWord;
// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();

//$textrun = $section->createTextRun();
//$textrun->addText('I am colored, array('color'=>'AACC00'));

// You can also put the appended element to local object an call functions like this:
$fontStyle = array('color'=>'B40404','spaceAfter' => 0);
$PHPWord->addFontStyle('rouge', $fontStyle);
$PHPWord->addParagraphStyle('pNormal', array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0));
$table = $section->addTable();
$table->addRow(100);
$cell=$table->addCell(4500);
$textrun = $cell->createTextRun();
$textrun->addText('V/.','rouge');
$textrun->addText('Deus, in adiutórium meum inténde.','pNormal');


//' Deus, in adiutórium meum inténde.');
$table->addCell(4500,'pNormal')->addText('V/. Dieu, viens à mon aide.','pNormal');
$table->addRow(100,'pNormal');
$table->addCell(4500,'pNormal')->addText('R/. Dómine, ad adiuvándum me festína.','pNormal');
$table->addCell(4500,'pNormal')->addText('R/. Seigneur, vite à mon secours.','pNormal');
$table->addRow(100,'pNormal');
$table->addCell(4500,'pNormal')->addText('Glória Patri, et Fílio, et Spirítui Sancto. Sicut erat in princípio, et nunc et semper, et in sæcula sæculórum. Amen.','pNormal');
$table->addCell(4500,'pNormal')->addText('Gloire au Père, au Fils et au Saint Esprit, comme il était au commencement, maintenant et toujours, et dans les siècles des siècles. Amen.','pNormal');
$table->addRow(100);
$table->addCell(4500,'pNormal')->addText('Allelúia.','pNormal');
$table->addCell(4500,'pNormal')->addText('Alléluia.','pNormal');

psaume($section,"ps90","fr");

// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('helloWorld.docx');


function psaume($section,$ref,$lang) {
$row = 0;


$table = $section->addTable();
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="/wp-content/plugins/liturgia/sources/".$ref.".xml";

$xml = @simplexml_load_file("http://92.243.24.163/".$refL) ; //or die("Error: Cannot create object : $refL");

//print"<br>OPEN : "."sources/".$ref.".csv";

$psaume="";
	
	foreach($xml->children() as $ligne){
	$o=$ligne->xpath('@id');
	$la=$ligne->xpath('la');
	$ver=$ligne->xpath($lang);
//	print"<br>".$o[0];
	if($o[0]==0) {
	if(($la[0])!=" ") {
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'rouge');
		$table->addCell(4500,'pNormal')->addText($ver[0],'rouge');
		
		//$psaume.= "<tr><td class=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></td><td class=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></td></tr>";
		}
	}
	elseif 	($o[0]==1) {
	if($la[0]!=" ") {
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'rouge');
		$table->addCell(4500,'pNormal')->addText($ver[0],'rouge');
		//$psaume.= "<tr><td  class=\"gauche\"><center><font color=red>".$la[0]."</font></center></td><td class=\"droite\"><center><font color=red>".$ver[0]."</font></center></td></tr>";
		}
	}
	
	elseif 	($o[0]==2) {
	if($la[0]!=" ") {
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'pNormal');
		$table->addCell(4500,'pNormal')->addText($ver[0],'pNormal');
		$psaume.= "<tr><td  class=\"gauche\"><center><i>".$la[0]."</i></center></td><td class=\"droite\"><center><i>".$ver[0]."</i></center></td></tr>";
		}
	}
	
	elseif 	($o[0]==3) {
		
	if($la[0]!=" ") {
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'rouge');
		$table->addCell(4500,'pNormal')->addText($ver[0],'rouge');
		//$psaume.= "<tr><td  class=\"gauche\"><center><font color=red><b>".$la[0]."</b></font></td><td class=\"droite\"><center><font color=red><b>".$ver[0]."</b></font></td></tr>";
		}
	}
	else  {
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'pNormal');
		$table->addCell(4500,'pNormal')->addText($ver[0],'pNormal');
	//$psaume.= "<tr><td  class=\"gauche\">".$la[0]."</td><td class=\"droite\">".$ver[0]."</td></tr>";
	}
}

	if($ref!="AT41") $psaume.=doxologie($section,$lang);
	//$psaume=rougis_verset($psaume);
	//$psaume=utf($psaume);
	//print $psaume;
	return $psaume;
}


function doxologie($section,$lang) {
	//$section = $PHPWord->createSection();
$table = $section->addTable();
	$xml = @simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/sources/ps_doxologie.xml");// or die("Error: Cannot create object : $refL");
	$doxologie="";
	foreach(@$xml->children() as $ligne){
		$la=$ligne->xpath('la');
		$ver=$ligne->xpath($lang);
		//$doxologie.= "<tr><td class=\"gauche\">".$la[0]."</td><td class=\"droite\">".$ver[0]."</td></tr>";
		$table->addRow(100,'pNormal');
		$table->addCell(4500,'pNormal')->addText($la[0],'pNormal');
		$table->addCell(4500,'pNormal')->addText($ver[0],'pNormal');
	}
	return $doxologie;
}

?>