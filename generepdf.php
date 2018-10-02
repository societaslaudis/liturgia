<?php 
/*
require_once("dompdf/dompdf_config.inc.php");
$html =
    '<html><body>'.
    '<p>Hello World!</p>'.
    '</body></html>';

$dompdf = new DOMPDF();
$dompdf->load_html($html);

$dompdf->render();
$dompdf->stream("hello_world.pdf");


*/
//$dompdf->output():

require_once("dompdf/dompdf_config.inc.php");


$xml = simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/calendrier/2013-04-12.xml");
$_SERVER['xml']=$xml;
$_SERVER['lang']="fr";
$_SERVER['traductions']=simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/traductions.xml");
$html = "<!DOCTYPE html>
<html lang=\"fr\"><head>
<!-- <link rel=\"stylesheet\" type=\"text/css\" href=\"pdfstyle.css\" /> -->

<meta	http-equiv=\"Content-Type\"	content=\"charset=utf-8\" />

</head><body><table>".laudes("20130412","RE")."</table></body></html>";

//print"\r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n ".$html;
file_put_contents("output.html", $html);
$dompdf = new DOMPDF();
$dompdf->load_html($html);

$dompdf->render();

// The next call will store the entire PDF as a string in $pdf

$pdf = $dompdf->output();

// You can now write $pdf to disk, store it in a database or stream it
// to the client.

file_put_contents("saved_pdf.pdf", $pdf);

function laudes($date,$ordo) {
	//$lang=$_GET['lang'];
//$option=$_GET['option'];
$lang="fr";
//$xml = simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/calendrier/".$date.".xml");
$xml=$_SERVER['xml'];
$prio=$xml->xpath("//ordo[@id='RE']//priorite");
$priorite=$prio[0];

//////// INTITULE
$output= intitule($date);
$output.="<tr><td class=\"gauche\"><center><i>Ad Laudes matutinas</i></center></td>
<td class=\"droite\"><center><i>".get_traduction("Ad Laudes matutinas", $lang)."</i></center></td></tr>";
// Initial
$output.= affiche_texte("initial_GHeure",$lang);
$output.= alleluia();

// Hymne
$hr=$xml->xpath("ordo[@id='RE']/HYMNUS_laudes");
$hrr=$hr[0];
$output.= hymne($hrr,$lang);

// ant1 et  PS1
$ar=$xml->xpath("ordo[@id='RE']/ant1");
$arr=$ar[0];
$output.= antienne($arr,$lang,"1");
$pr=$xml->xpath("ordo[@id='RE']/ps1");
$prr=$pr[0];
$output.= psaume($prr,$lang);
$output.= antienne($arr,$lang);
// ant2 et  PS2
$ar=$xml->xpath("ordo[@id='RE']/ant2");
$arr=$ar[0];
$output.= antienne($arr,$lang,"2");
$pr=$xml->xpath("ordo[@id='RE']/ps2");
$prr=$pr[0];
$output.= psaume($prr,$lang);
$output.= antienne($arr,$lang);
// ant3 et  PS3
$ar=$xml->xpath("ordo[@id='RE']/ant3");
$arr=$ar[0];
$output.= antienne($arr,$lang,"3");
$pr=$xml->xpath("ordo[@id='RE']/ps3");
$prr=$pr[0];
$output.= psaume($prr,$lang);
$output.= antienne($arr,$lang);

// Lecon et répons bref
$lr=$xml->xpath("ordo[@id='RE']/LB_matin");
$lrr=$lr[0];
$output.= lectiobrevis($lrr,$lang);

$rr=$xml->xpath("ordo[@id='RE']/RB_matin");
$rrr=$rr[0];
$output.= reponsbref($rrr,$lang);
//print $output;
// Antienne et Benedictus
$br=$xml->xpath("ordo[@id='RE']/benedictus");
$brr=$br[0];
$output.= antienne($brr,$lang);
$output.= psaume("benedictus",$lang);
$output.= antienne($brr,$lang);

$preces=$xml->xpath("ordo[@id='RE']/laudes_preces");

$pp="PRECES_".$preces[0]."_laudes";
$output.= preces($pp,$lang);
$output.= pater($lang);
$oratio=$xml->xpath("ordo[@id='RE']/oratio_laudes");
//print_r($oratio);
$output.= collecte($oratio[0],$lang);
/// CONCLUSION
$output.= affiche_texte("LH_conclusion_Gheure",$lang);

return $output;
}




function datets($jour) {
if(!$jour) $jour=$_GET['jour'];
if(!$jour) $jour=$_GET['date'];
if(!$jour) $jour=date("Ymd",time());
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$date_ts=mktime(12,0,0,$mense,$die,$anno);

//print"<br>Jour=".$jour;
$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
//print"<br> Jour de la semaine : ".$jours_l[date('w',$date_ts)];
$date['ts']=$date_ts;
$date['AAAAMMJJ']=$jour;
return $date;
}
function date2dateTS($date) { // format AAAAMMJJ
	$anno=substr($date,0,4);
	$mense=substr($date,4,2);
	$die=substr($date,6,2);
	$dts=mktime(12,0,0,$mense,$die,$anno);
	//print "<br>".$dts;
	return $dts;
	
}
function date_latin($j) {
	if($j==null) $j=time();
 $mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
 $jours = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
 $date= $jours[@date("w",$j)]." ".@date("j",$j)." ".$mois[@date("n",$j)-1]." ".@date("Y",$j);
 return $date;
}

function affiche_tableau($tableau,$office) {
	if($office=="laudes") {
		$t="
		<table>
		<th>Psautier</th>
		<th>Temporal</th>
		<th>Propre</th>
		<th>Special</th>";
		$t.="
		<tr>
		<td>".$tableau['matin']['psalterium']."</td>
		<td>".$tableau['matin']['ferie']."</td>
		<td>".$tableau['matin']['propre']."</td>
		<td>".$tableau['matin']['special']."</td>";
		$t.="</table>";
	}
	return $t;

}

function get_traduction($atraduire,$lang) {

$traductions=$_SERVER['traductions'];

$lang="fr";
$path="//item[@ref='".$atraduire."']//".$lang;
//$path="//item[@ref='Tempus Quadragesimae']/fr";
//print"<br>".$path." ";
$traduit=@$traductions->xpath($path);
//print $traduit[0];
if(!$traduit[0]) return $atraduire;
else return $traduit[0];
}

function get_date($date,$calendarium) {
if(!$date) $date=$_GET['date'];
if(!$date) $date=date("Ymd",time());
$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$date_ts=mktime(12,0,0,$mense,$die,$anno);
$output=strftime("%A %#d %B %Y",$date_ts);

$output.="<br>".$calendarium['intitule'][$date];
/*//print_r($calendarium);
*/	
	
	return $output;
	
}

function rougis_verset($string) {
$string1=str_replace("V/.", "<font color=red>V/.</font>",$string);
$string2= str_replace("R/.", "<font color=red>R/.</font>",$string1);
$string3= str_replace("", "<font color=red></font>",$string2);
$string4= str_replace("*", "<font color=red>*</font>",$string3);
$string5= str_replace("]", "<font color=red>]</font>",$string4);
$string6= str_replace("[", "<font color=red>[</font>",$string5);
$string7= str_replace("†", "<font color=red>†</font>",$string6);
$string8= str_replace("—", "<font color=red>—</font>",$string7);

return $string8;
}

function lectio($ref) {
//$prefixe="http://gregorien.radio-esperance.fr/";
	$row = -1;
	$fp = @fopen ($prefixe."calendrier/liturgia/$ref.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	$row++;
	  $latin=nl2br($data[0]);
		if ($lang=="fr") $verna=nl2br($data[1]);
		if ($lang=="en") $verna=nl2br($data[2]);
		if ($lang=="ar") $verna=nl2br($data[3]);
		
		if($row==0){		
		$lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$verna</td>";
			}
			   
		elseif($row==1) {
		$lectio.="
		<tr><td id=\"colgauche\"><center><font color=red>$latin</font></center></td><td id=\"coldroite\"><center><font color=red>$verna</font></center></td>";
		}
		elseif($row==2) {
		$lectio.="
		<tr><td id=\"colgauche\"><center><font color=red><i>$latin</i></font></center></td><td id=\"coldroite\"><center><font color=red><i>$verna</i></font></center></td>";
		}
		else {
		$lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$verna</td>";	
		}
	}	
 
	@fclose ($fp);
	return $lectio;
}

function modificationes($messe,$lang) {
           $option=$_GET['option'];
$row = 0;
$ref=no_accent($ref);
$ref="sources/".$ref.".csv";
$fp = fopen ($ref,"r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    //$messe[$id];
	    if($lang=="fr")$verna=$data[4];
	    if($lang=="en")$verna=$data[5];
	    if($lang=="ar")$verna=$data[6];
		}    
	   
	    $modificationes.="
		<div class=\"gauche\">$latin".affiche_editeur($ref,"lat")."</div>
		<div class=\"droite\">$verna".affiche_editeur($ref,$lang)."</div>";	
		$row++;	

	@fclose ($fp);
	return $modificationes;
}


function recitatif  ($ref,$lang) {
  $option=$_GET['option'];
$row = 0;
$ref=no_accent($ref);
$ref="sources/".$ref.".csv";
$fp = @fopen ($ref,"r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];
	    if($lang=="fr")$verna=$data[1];
	    if($lang=="en")$verna=$data[2];
	    if($lang=="ar")$verna=$data[3];
	    
	   
	    $recitatif.="
		<div class=\"gauche\">$latin".affiche_editeur($ref,"lat")."</div>
		<div class=\"droite\">$verna".affiche_editeur($ref,$lang)."</div>";	
		$row++;	
	}
	@fclose ($fp);
	return $recitatif;
}


function ordinaire_messe($ordinaire,$ref,$lang) {
       $ordi.="
		<div class=\"gauche\">".nl2br($ordinaire[$ref]['lat'])."</div>
		<div class=\"droite\">".nl2br($ordinaire[$ref]['verna'])."</div>";
		return $ordi;
}

function alleluia() { // fonction pour afficher alleluia à la fin du verset d'introduction de l'office
	$alleluia="<tr>
		<td class=\"gauche\"> Allelúia.</td>
		<td class=\"droite\">".get_traduction(" Allelúia.",$_SERVER['lang'])."</td></tr>";
	//print_r($GLOBALS['liturgia']->tempus);
	$req="//ordo[@id='RE']/tempus/la";
	$tt=$_SERVER['xml']->xpath($req);
	//print_r($tt);
	if($tt[0]=="Tempus Quadragesimae") return null;	
	if($tt[0]=="Tempus passionis") return null;	
	else return $alleluia;
}

function lectiobrevis($ref,$lang) {

//$option=$_GET['option'];
$ref=no_accent($ref);
$refL="/wp-content/plugins/liturgia/sources/".$ref.".xml" ;
$xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("Error: Cannot create object : $refL");
$lectio="";			 	
foreach(@$xml->children() as $ligne){
	$o=$ligne->xpath('@id');
	$la=$ligne->xpath('la');
	$ver=$ligne->xpath($lang);
	
	if($o[0]==0) {
		$lectio.= "<tr><td class=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></td><td class=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></td></tr>";
	}
	else {
		$lectio.= "<tr><td class=\"gauche\">".$la[0]."</td><td class=\"droite\">".$ver[0]."</td></tr>";
	}
}

	return $lectio;
}

function preces($ref,$lang) {
	//$option=$_GET['option']; 
	$ref=no_accent($ref);
	$preces="";
	$preces.="<tr><td class=\"gauche\"><font color=red><center>Preces  </center></font></td>";
	$preces.="<td class=\"droite\"><font color=red><center>Prières litaniques. </center></font></td>";
	
	$preces.=affiche_texte($ref, $lang);
		
	return $preces;

}

function antienne($ref,$lang,$num="") {
//$option=$_GET['option'];
$ref=no_accent($ref);
//$prefixe="http://gregorien.radio-esperance.fr/";

$refL="/wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
$xml = @simplexml_load_file("http://92.243.24.163/".$refL); // or die("Erreur : ".$refL);

//print"<br>OPEN : "."sources/".$ref.".csv";
$la=$xml->xpath('//ligne//la');
$expr="//ligne//".$lang;
$ver=$xml->xpath($expr);
$antienne="";	
	
	$antienne.="<tr><td class=\"gauche\"><font color=red>Ant. ".$num." </font>".$la['0']."</td>";
	$antienne.="<td class=\"droite\"><font color=red>Ant. ".$num."</font> ".$ver['0']."</td></tr>";
	return $antienne;
}

function reponsbref($ref,$lang) {
//$option=$_GET['option'];
//$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="/wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
$xml = simplexml_load_file("http://92.243.24.163".$refL) ; //or die ("erreur : "."wp-content/plugins/liturgia/".$ref);

$la=@$xml->xpath('//ligne/la');
$expr="//ligne/".$lang;
$ver=@$xml->xpath($expr);

$reponsbref="<tr>
   	<td class=\"gauche\"><font color=red><center><b>Responsorium Breve</b></font></td>
	<td class=\"droite\"><font color=red><center><b>".get_traduction("Responsorium Breve",$lang)."</b></center></font></td>
	</tr><tr>
	<td class=\"gauche\">".affiche_editeur($refL,"la")."</td>
	<td class=\"droite\">".affiche_editeur($refL,$lang)."</td>
	";
	for($v=0;$la[$v];$v++) {
		$reponsbref.="<tr><td class=\"gauche\">".nl2br($la[$v])."</td>";
		$reponsbref.="<td class=\"droite\">".nl2br($ver[$v])."</td></tr>";
	}
	return rougis_verset($reponsbref);
	//return $reponsbref;
}

function verset($ref,$lang) {
$option=$_GET['option'];
//$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="/wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
$xml = @simplexml_load_file("http://92.243.24.163".$refL) ; //or die ("erreur : "."wp-content/plugins/liturgia/".$ref);
if((!$xml)&&($_GET['edition']=="on")) {
	$verset="<div class=\"gauche\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">".$ref."</a></div>";
	$verset.="<div class=\"droite\"></div>";
	return $verset;
}
//print"<br>OPEN : "."sources/".$ref.".csv";
//print_r($xml);
$la=@$xml->xpath('//ligne/la');
$expr="//ligne/".$lang;
$ver=@$xml->xpath($expr);

$verset="
	<div class=\"gauche\">".affiche_editeur($ref,"la")."</div>
	<div class=\"droite\">".affiche_editeur($ref,$lang)."</div>
	";
	$verset.="
		<div class=\"gauche\">".mp3Player($mp3)."</div>
		<div class=\"droite\">&nbsp;</div>";
	for($v=0;$la[$v];$v++) {
		$verset.="<div class=\"gauche\">".nl2br($la[$v])."</div>";
		$verset.="<div class=\"droite\">".nl2br($ver[$v])."</div>";
	}
	return $verset;
}



function hymne($ref,$lang,$mp3="") {
$row = 0;
//$prefixe="http://gregorien.radio-esperance.fr/";
$refL="/wp-content/plugins/liturgia/sources/".$ref.".xml";
//print"<br>";
//print_r($_SERVER);
//print "<br>".$refL;
$xml = simplexml_load_file("http://92.243.24.163/".$refL) or die("Error: Cannot create object : $refL");

//print_r($xml);

$hymne="";
	
	
	foreach($xml->children() as $ligne){
	$o=@$ligne->xpath('@id');
	$la=@$ligne->xpath('la');
	$ver=@$ligne->xpath($lang);
//	print"<br>".$o[0];
	
	if($o[0]==0) {
	$hymne.= "<tr><td class=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></td><td class=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></td></tr>";
	}
	elseif($la[0]==null) $hymne.= "<tr><td class=\"gauche\">&nbsp;</div><div class=\"droite\">&nbsp;</td></tr>";
	
	else	$hymne.= "<tr><td class=\"gauche\"><center>".$la[0]."</center></td><td class=\"droite\"><center>".$ver[0]."</center></td></tr>";
	}

	return $hymne;
}


function antienne_messe($ref,$lang) {
$option=$_GET['option'];
if(!$lang) $lang=$GLOBALS['lang'];
if(!$lang) $lang="fr";
$ref=trim($ref);
$refL="wp-content/plugins/liturgia/sources/propres/messe/".$ref.".xml";
//print"<br>";
//print_r($_SERVER);
//print "<br>".$refL;
if($_GET['debug']==1) $antiennemesse.="
<div class=\"gauche\">".$ref."</div>
<div class=\"droite\">".$ref."</div>
";
$xml = @simplexml_load_file("http://92.243.24.163/".$refL); // or die("Error: Cannot create object : $refL");
if(!$xml) {
	//print" - Référence : ".$ref." -> <a href=\"javascript:affichage_popup('?task=creation&lang=$lang&comment=".$refL."','affichage_popup');\">Création</a>";
	if ($_GET['edition']=="on") $antiennemesse="
	<div class=\"gauche\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">".$ref."</a></div>
	<div class=\"droite\"> </div>";
	return $antiennemesse;
}

//print"<br>OPEN : "."sources/".$ref.".csv";
$antiennemesse.="</center>";
$antiennemesse.="
	<div class=\"gauche\">".affiche_editeur($refL,"la")."</div>
	<div class=\"droite\">".affiche_editeur($refL,$lang)."</div>
	";
/*	
$antiennemesse.="
		<div class=\"gauche\">".mp3Player($mp3)."</div>
		<div class=\"droite\">&nbsp;</div>";
*/	
$o=0;
foreach(@$xml->children() as $ligne){
	//$o=@$ligne->xpath('@id');
	$la=@$ligne->xpath('la');
	$ver=@$ligne->xpath($lang); 
	if($o==0)$antiennemesse.= "
	<div class=\"gauche liturgie_titre\">".$la[0]."</div>
	<div class=\"droite liturgie_titre\">".$ver[0]."</div>";
	elseif ($o==1) $antiennemesse.="	<div class=\"gauche liturgie_italique\">".$la[0]."</div>	<div class=\"droite liturgie_italique\">".$ver[0]."</div>";
	else $antiennemesse.="	<div class=\"gauche\">".$la[0]."</div>	<div class=\"droite\">".$ver[0]."</div>";
	$o++;
}
return $antiennemesse;
}

function affiche_editeur($ref,$lang) {
	return;
	/* Verification
		1 - des droits de l'utilisateur
		2 - de l'éditabilité du contenu concerné.
	*/
	//if($_GET['edition']=="on") $verif=true;
	/*
	$q=$_GET['q'];
	$auth=true;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	*/
	//if ($_GET['option']=="edit") $verif=true;
	// code à compléter.
	if ($verif) { // contenu éditable et droits de l'utilisateur OK.
		$editeur=" &nbsp; <A HREF=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?option=edit&affiche=1&task=edit&lang=$lang&ref=/$ref','affichage_popup');\"><b>éditer</b></A>";
	}	
	return $editeur;	
}

/*
function affiche_editeur_propre($id,$ref,$lang) {
	/* Verification
		1 - des droits de l'utilisateur
		2 - de l'éditabilité du contenu concerné.
	*/
/*
	$q=$_GET['q'];
	$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	if ($_GET['option']=="edit") $verif=(true);
	// code à compéter.
	if ($verif) { // conteu éditable et droits de l'utilisateur OK.
		$editeur=" &nbsp; <A HREF=\"javascript:affichage_popup('?q=$q&task=edit_propre&id=$id&lang=$lang&ref=$ref','affichage_popup');\">éditer</A>";
	}
	
	return $editeur;
	
}
*/


function edit_content() {
	$auth=true;
	if(!$auth) return;
	
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	$sens="";
	if ($lang=="ar") $sens="style=\"direction:rtl; font:20px arial,sans-serif;\"";
	$q=$_GET['q'];
	$edit_content.="
	<html>
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	</head>
	<body>
	<form method='post' action='?q=$q&task=maj&ref=$ref&lang=$lang'>
	<textarea $sens name='miseajour' cols=\"45\" rows=\"12\">";
	$xml = simplexml_load_file(get_bloginfo('wpurl').$ref) or die("erreur : $ref");
	$re=explode("/",$ref);
	$r=$re[count($re)-1];
	$r = str_replace(".xml", null, $r);

	$content=$xml->xpath($lang);
	if(!$content) {
	
	foreach ($xml->children() as $item) { 
		$el=$item->xpath($lang);
		$edit_content.=trim($el[0])."\r";
		}
	}

	$edit_content.=trim($content[0])."\r";	
	$edit_content.="</textarea>
	<input type=\"hidden\" name=\"lang\" value=\"".$lang."\">
	<INPUT type=\"submit\" value=\"Envoyer\">
	</form>
	</body>
	</html>
	";
	print $edit_content;
	exit();
}

function edit_content_propre() {
	$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;
	if(!$auth) return;
	
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	$id=$_GET['id'];
	$q=$_GET['q'];
	$refL="sources/".no_accent($ref);
	$edit_content_propre.="
	<form method='post' action='?q=$q&task=maj_propre&id=$id&ref=$ref&lang=$lang'>
	<textarea name='miseajour' cols=\"45\" rows=\"12\">";
	$fp = fopen ("$refL","r","1");  //or die ("<br>Erreur ouverture fichier : ".$refL);
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	    $i=$data[0];
	    $edit[$i]['lat']=$data[1];
	    $edit[$i]['mode']=$data[2];
	    $edit[$i]['mp3']=$data[3];
	    $edit[$i]['fr']=$data[4];
	    $edit[$i]['en']=$data[5];
	    $edit[$i]['ar']=$data[6];
	    $row++;
	}
	
	@fclose ($fp);	
	$edit_content_propre.=$edit[$id][$lang]."</textarea>
	<INPUT type=\"submit\" value=\"Envoyer\" ONCLICK=\"window.close()\">
	</form>
	";
	print $edit_content_propre;
	exit();
}

function maj_content($miseajour,$userid) {
	global $wpdb;
	$ref=$_GET['ref'];
	$lang=$_GET['lang'];
	if($lang=="la") $miseajour=creation_accents($miseajour);
	$datets=time();
	  $miseajour=addslashes($miseajour);
	$q="insert into liturgia_ed(user,ref_texte,lang,nouveau_texte,date_ts) values('$userid','$ref','$lang','$miseajour','$datets') ";  
  	$wpdb->query($q);
	  print"<html><head>
	  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head><body><br>Mise à jour effectuée. Votre proposition sera validée prochainement.</body></html>";
	  exit();
}


function intitule($date){
	 /*	
	if($GLOBALS['rang']!="") print $GLOBALS['intitule'].", ".$GLOBALS['rang'].".";
	else print $GLOBALS['hebdomada'];
	*/
	//print $GLOBALS['hebdomada'];
	//$date=$_GET['date'];
	$date_ts=date2dateTS($date);
	$die=array("Dominica","Feria II","Feria III","Feria IV","Feria V","Feria VI","Sabbato");
	$lang="fr";
	
	$xml=$_SERVER['xml'];
	$req="//ordo[@id='RE']";
	$r=$xml->xpath($req);
	//print_r($r[0]);
	$hebdomada=$r[0]->hebdomada->la;
	
	$int="
	<tr>
	<td class=\"gauche\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".$hebdomada."</td>
	<td class=\"droite\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".ucfirst(get_traduction($hebdomada,$lang))."</td>
	</tr>
	";
	$int.="
	<tr>
	<td class=\"gauche\" style=\"font-size: 1.1em;font-weight: 300;text-align:center;\">".$die[date('w',$date_ts)]."</td>
	<td class=\"droite\" style=\"font-size: 1.1em;font-weight: 300;text-align:center;\">".ucfirst(get_traduction($die[date('w',$date_ts)],$lang))."</td>
	</tr>
	";
	$intitule_la=$r[0]->intitule->la;
	if($lang=="fr") $intitule_ver=$r[0]->intitule->fr;
	if($lang=="en") $intitule_ver=$r[0]->intitule->en;
	if($lang=="ar") $intitule_ver=$r[0]->intitule->ar;
	if($intitule_la!="") {
		$int.="
		<tr>
		<td class=\"gauche\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".$intitule_la."</td>
		<td class=\"droite\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".$intitule_ver."</td>
		</tr>
		";
		$rang=$r[0]->rang->la;
		$rang_ver=get_traduction($rang, $lang);
		if($rang) $int.="
		<tr>
		<td class=\"gauche\" style=\"font-size: 1.1em;font-weight: 300;text-align:center; font-style:italic\">".$rang."</td>
		<td class=\"droite\" style=\"font-size: 1.1em;font-weight: 300;text-align:center; font-style:italic\">".$rang_ver."</td>
		</tr>";
	}
	return $int;
}

function intitule_soir(){
	 /*	
	if($GLOBALS['rang']!="") print $GLOBALS['intitule'].", ".$GLOBALS['rang'].".";
	else print $GLOBALS['hebdomada'];
	*/
	//print $GLOBALS['hebdomada'];
	//$date=$_GET['date'];
	$date_ts=$GLOBALS['date_ts'];
	$die=array("Dominica","Feria II","Feria III","Feria IV","Feria V","Feria VI","Sabbato");
	$lang=$GLOBALS['lang'];
	$xml = $GLOBALS['liturgia'];
	$req="//ordo[@id='RE']";
	$r=$xml->xpath($req);
	//print_r($r[0]);
	$hebdomada=$r[0]->hebdomada->la;
	
	$int="
	<div class=\"gauche\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".$hebdomada."</div>
	<div class=\"droite\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".ucfirst(get_traduction($hebdomada,$lang))."</div>
	";
	$int.="
	<div class=\"gauche\" style=\"font-size: 1.1em;font-weight: 300;text-align:center;\">".$die[date('w',$date_ts)]."</div>
	<div class=\"droite\" style=\"font-size: 1.1em;font-weight: 300;text-align:center;\">".ucfirst(get_traduction($die[date('w',$date_ts)],$lang))."</div>
	";
	$intitule_la=$r[0]->intitule_soir->la;
	/*
	if($lang=="fr") $intitule_ver=$r[0]->intitule->fr;
	if($lang=="en") $intitule_ver=$r[0]->intitule->en;
	if($lang=="ar") $intitule_ver=$r[0]->intitule->ar;
	*/
	
	if($intitule_la!="") {
		$int.="
		<div class=\"gauche\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".$intitule_la."</div>
		<div class=\"droite\" style=\"font-size: 1.1em;font-weight: 900;text-align:center;\">".get_traduction($intitule_la, $lang)."</div>
		";
		$rang=$r[0]->rang_soir->la;
		$rang_ver=get_traduction($rang, $lang);
		if($rang) $int.="
		<div class=\"gauche\" style=\"font-size: 1.1em;font-weight: 300;text-align:center; font-style:italic\">".$rang."</div>
		<div class=\"droite\" style=\"font-size: 1.1em;font-weight: 300;text-align:center; font-style:italic\">".$rang_ver."</div>
		";
	}
	return $int;
}

function lecture_messe($ref,$lang) {
	if(!$lang) $lang=$GLOBALS['lang'];
	if(!$lang) $lang="fr";
     $refL="wp-content/plugins/liturgia/sources/propres/messe/lectures/".$ref.".xml";
	 //print"<br>refL = ".$refL;
     $xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 //$ref="LEC_".no_accent($ref);
	 
     if(!$xml) {
	 	$LM ="
	 	<div class=\"gauche\" style=\"font-style:oblique;\">";
	 	if($_GET['edition']=="on") $LM.="<a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=/".$refL."','affichage_popup');\">".$ref."</a>";
	 	$LM.="</div>
	 	<div class=\"droite\">&nbsp;</div>
	   <div class=\"gauche\">Verbum Domini. R/. Deo gratias.</div>";
	   if ($lang=="fr") $LM.="<div class=\"droite\">Parole du Seigneur. R/. Rendons grâces à Dieu.</div>";
	   if ($lang=="en") $LM.="<div class=\"droite\">Word of the Lord. R/. Thanks be to God.</div>";
    return $LM;
	 	//print" - Référence : ".$refL." -> <a href=\"javascript:affichage_popup('?task=creation&lang=$lang&comment=".$refL."','affichage_popup');\">Création</a>";
	 }
	 
	
//print"<br>OPEN : ".$refL;
	$LM.="
	<div class=\"gauche\">".affiche_editeur($refL,"la")."</div>
	<div class=\"droite\">".affiche_editeur($refL,$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	//	print"<br>".$o[0];
		if($o[0]==0) {
		$LM.= "
		<div class=\"gauche liturgie_italique\">".$la[0]."</div>
		<div class=\"droite liturgie_italique\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$LM.= "
		<div class=\"gauche\">".$la[0]."</div>
		<div class=\"droite\">".$ver[0]."</div>";
		}
	}

     $LM .="
	   <div class=\"gauche\">Verbum Domini. R/. Deo gratias.</div>";
	   if ($lang=="fr") $LM.="<div class=\"droite\">Parole du Seigneur. R/. Rendons grâces à Dieu.</div>";
	   if ($lang=="en") $LM.="<div class=\"droite\">Word of the Lord. R/. Thanks be to God.</div>";
    return $LM;
}


function lecture_vigiles($ref,$lang,$ordre) {
$option=$_GET['option'];
$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="sources/propres/OSB_Vigiles/".$ref.".xml";

     $refL="/wp-content/plugins/liturgia/sources/propres/OSB_Vigiles/".$ref.".xml";
	 //print"<br>refL = ".$refL;
     $xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 //$ref="LEC_".no_accent($ref);
	 
     if(!$xml) {
	 	$lecture_vigiles ="<div class=\"gauche\" style=\"font-style:oblique;\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">$ref</a></div><div class=\"droite\">&nbsp;</div>";   
    return $lecture_vigiles;
	 }
	 
	$lecture_vigiles.="
	<div class=\"gauche\">Lectio $ordre ".affiche_editeur($refL,"la")."</div>
	<div class=\"droite\">Lecture $ordre ".affiche_editeur($refL,$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
		if($o[0]==0) {
		$lecture_vigiles.= "
		<div class=\"gauche\"><i>".$la[0]."</i></div>
		<div class=\"droite\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$lecture_vigiles.= "
		<div class=\"gauche\">".$la[0]."</div>
		<div class=\"droite\">".$ver[0]."</div>";
		}
	}

	return $lecture_vigiles;
}

function lecture_OL($ref,$lang,$ordre) {
$option=$_GET['option'];
$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="sources/propres/office/".$ref.".xml";

     $refL="/wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
	 //print"<br>refL = ".$refL;
     $xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 //$ref="LEC_".no_accent($ref);
	 
     if(!$xml) {
	 	$lecture_OL ="<div class=\"gauche\" style=\"font-style:oblique;\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">$ref</a></div><div class=\"droite\">&nbsp;</div>";   
    return $lecture_OL;
	 }
	 
	$lecture_OL.="
	<div class=\"gauche\">Lectio $ordre ".affiche_editeur($refL,"la")."</div>
	<div class=\"droite\">Lecture $ordre ".affiche_editeur($refL,$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	//	print"<br>".$o[0];
		if($o[0]==0) {
		$lecture_OL.= "
		<div class=\"gauche\"><i>".$la[0]."</i></div>
		<div class=\"droite\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$lecture_OL.= "
		<div class=\"gauche\">".$la[0]."</div>
		<div class=\"droite\">".$ver[0]."</div>";
		}
	}

	return $lecture_OL;
}



function creation_accents($texte) {
	//print"OK";
	$voyelles_sans_accent = array("+","'a", "'i", "'o", "'u", "a'e", "'y", "'A", "'I", "'O", "'U", "A'E","'Y");
	$voyelles_avec_accent = array("†","á", "í", "ó", "ú", "ǽ", "ý", "Á", "Í", "Ó", "Ú", "Ǽ","Ý");
	$texte_final = str_replace($voyelles_sans_accent, $voyelles_avec_accent, $texte);
	return $texte_final;
}

function repons_vigiles($ref,$lang,$ordre) {
$option=$_GET['option'];
$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="sources/propres/OSB_Vigiles/".$ref.".xml";
$xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 
	  $repons_vigiles="
		<div class=\"gauche\" align=\"center\" ><font color=red>Responsorium $ordre</font> ".affiche_editeur($refL,'lat')."</div>
		<div class=\"droite\" align=\"center\"><font color=red>Répons $ordre</font> ".affiche_editeur($refL,$lang)."</div>";
    if(!$xml) {
	 	$repons_vigiles ="<div class=\"gauche\" style=\"font-style:oblique;\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">$ref</a></div><div class=\"droite\">&nbsp;</div>";   
    return $repons_vigiles;
	 }   
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
		$repons_vigiles.= "
		<div class=\"gauche\">".$la[0]."</div>
		<div class=\"droite\">".$ver[0]."</div>";
		}	 
	return $repons_vigiles;
}



function repons($ref,$lang) {
$option=$_GET['option'];
//$prefixe="http://gregorien.radio-esperance.fr/";
$row = 0;
$ref=no_accent($ref);
$refL="/wp-content/plugins/liturgia/sources/propres/office/".$ref.".xml";
$xml = @simplexml_load_file("http://92.243.24.163".$refL) ; //or die ("erreur : "."wp-content/plugins/liturgia/".$ref);
if((!$xml)&&($_GET['edition']=="on")) {
	$verset="<div class=\"gauche\"><a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=".$refL."','affichage_popup');\">".$ref."</a></div>";
	$verset.="<div class=\"droite\"></div>";
	return $verset;
}
//print"<br>OPEN : "."sources/".$ref.".csv";
//print_r($xml);
$la=@$xml->xpath('//ligne/la');
$expr="//ligne/".$lang;
$ver=@$xml->xpath($expr);

$verset="
	<div class=\"gauche\">".affiche_editeur($ref,"la")."</div>
	<div class=\"droite\">".affiche_editeur($ref,$lang)."</div>
	";
	$verset.="
		<div class=\"gauche\">".mp3Player($mp3)."</div>
		<div class=\"droite\">&nbsp;</div>";
	for($v=0;$la[$v];$v++) {
		$verset.="<div class=\"gauche\">".nl2br($la[$v])."</div>";
		$verset.="<div class=\"droite\">".nl2br($ver[$v])."</div>";
	}
	return $verset;
}

function evangile_vigiles($ref,$lang) {
$prefixe="http://gregorien.radio-esperance.fr/";
     $refL="/wp-content/plugins/liturgia/sources/propres/messe/lectures/EV_".$ref.".csv";
     $fp = fopen ($prefixe.$refL,"r","1");
     $row=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	if (($row==0)&&($data[0]!="")) {
		$latin=$data[0];		
			if($lang=="fr") $verna=$data[1];
			if($lang=="en") $verna=$data[2];
			if($lang=="ar") $verna=$data[3];
			$data[0]="";
	}
	else {
	    $latin=$data[0];
	    if ($lang=="fr") $verna=$data[1];
	    if ($lang=="en") $verna=$data[2];
	    if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
	  }
	    $LM .="
	   <div class=\"gauche\">$latin</div>
	   <div class=\"droite\">$verna</div>";
  	 $row++;
    }
     $LM .="
	   <div class=\"gauche\">R/. Amen.</div>";
	   if ($lang=="fr") $LM.="<div class=\"droite\">R/. Amen.</div>";
    return $LM;
}

function evangile($ref,$lang) {
	if(!$lang) $lang=$GLOBALS['lang'];
	if(!$lang) $lang="fr";
	print"<div class=\"gauche\" style=\"color:red;font-weight: 900;text-align:center;\">Evangelium</div>
	<div class=\"droite\" style=\"color:red;font-weight: 900;text-align:center;\">".get_traduction("Evangelium",$lang)."</div>
	";
     $refL="wp-content/plugins/liturgia/sources/propres/messe/lectures/".$ref.".xml";
	 //print"<br>refL = ".$refL;
     $xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	 //$ref="LEC_".no_accent($ref);
	 
if(!$xml) {
	 	$LM ="
	 	<div class=\"gauche\" style=\"font-style:oblique;\">";
	 	if($_GET['edition']=="on") $LM.="<a href=\"javascript:affichage_popup('http://92.243.24.163/chant-gregorien/liturgia/?task=creation&lang=la&comment=/".$refL."','affichage_popup');\">".$ref."</a>";
	 	$LM.="</div>
	 	<div class=\"droite\">&nbsp;</div>
	   <div class=\"gauche\">Verbum Domini. R/. Deo gratias.</div>";
	   if ($lang=="fr") $LM.="<div class=\"droite\">Parole du Seigneur. R/. Rendons grâces à Dieu.</div>";
	   if ($lang=="en") $LM.="<div class=\"droite\">Word of the Lord. R/. Thanks be to God.</div>";
    return $LM;
	 	//print" - Référence : ".$refL." -> <a href=\"javascript:affichage_popup('?task=creation&lang=$lang&comment=".$refL."','affichage_popup');\">Création</a>";
	 }
	 
	
//print"<br>OPEN : ".$refL;
	$LM.="
	<div class=\"gauche\">".affiche_editeur($refL,"la")."</div>
	<div class=\"droite\">".affiche_editeur($refL,$lang)."</div>
	";
		
foreach(@$xml->children() as $ligne){
		$o=@$ligne->xpath('@id');
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	//	print"<br>".$o[0];
		if($o[0]==0) {
		$LM.= "
		<div class=\"gauche liturgie_italique\">".$la[0]."</div>
		<div class=\"droite liturgie_italique\"><i>".$ver[0]."</i></div>";
		}
		else	{
		$LM.= "
		<div class=\"gauche\">".$la[0]."</div>
		<div class=\"droite\">".$ver[0]."</div>";
		}
	}

     $LM .="
	   <div class=\"gauche\">Verbum Domini. R/. Laus tibi, Christe.</div>";
	   if ($lang=="fr") $LM.="<div class=\"droite\">Parole du Seigneur. R/. Louange à Toi, ô Christ.</div>";
	   if ($lang=="en") $LM.="<div class=\"droite\">Word of the Lord. R/. Praise be to thee, Christ.</div>";
    return $LM;
}

function paroles($ref) {
  $s=explode("_",$ref);
  $type=$s[0];
  if($type=="IN") $output = antienne_messe($ref,$lang);
  if($type=="OF") $output = antienne_messe($ref,$lang);
  if($type=="CO") $output = antienne_messe($ref,$lang);
  if($type=="GR") $output = antienne_messe($ref,$lang);
  if($type=="AL") $output = antienne_messe($ref,$lang);
  if($type=="TR") $output = antienne_messe($ref,$lang);
  if($type=="SEQ") $output = antienne_messe($ref,$lang);
  if($type=="HY") $output = hymne($ref);
  if ($output) return $output;
  else return "Ce texte n'est pas disponible pour le moment. Pour nous à aider à rendre disponible ce texte, vous pouvez vous inscire sur le site web. D'avance merci.";
}


function psaume($ref,$lang) {
$row = 0;
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
	if(($la[0])!=" ") $psaume.= "<tr><td class=\"gauche\"><b><center><font color=red>".$la[0]."</font></b></center></td><td class=\"droite\"><b><center><font color=red>".$ver[0]."</font></b></center></td></tr>";
	}
	elseif 	($o[0]==1) {
	if($la[0]!=" ") $psaume.= "<tr><td  class=\"gauche\"><center><font color=red>".$la[0]."</font></center></td><td class=\"droite\"><center><font color=red>".$ver[0]."</font></center></td></tr>";
	}
	
	elseif 	($o[0]==2) {
	if($la[0]!=" ") $psaume.= "<tr><td  class=\"gauche\"><center><i>".$la[0]."</i></center></td><td class=\"droite\"><center><i>".$ver[0]."</i></center></td></tr>";
	}
	
	elseif 	($o[0]==3) {
	if($la[0]!=" ") $psaume.= "<tr><td  class=\"gauche\"><center><font color=red><b>".$la[0]."</b></font></td><td class=\"droite\"><center><font color=red><b>".$ver[0]."</b></font></td></tr>";
	}
	else  {
	$psaume.= "<tr><td  class=\"gauche\">".$la[0]."</td><td class=\"droite\">".$ver[0]."</td></tr>";
	}
}

	if($ref!="AT41") $psaume.=doxologie($lang);
	$psaume=rougis_verset($psaume);
	$psaume=utf($psaume);
	//print $psaume;
	return $psaume;
}


function doxologie($lang) {
	$xml = @simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/sources/ps_doxologie.xml");// or die("Error: Cannot create object : $refL");
	$doxologie="";
	foreach(@$xml->children() as $ligne){
		$la=$ligne->xpath('la');
		$ver=$ligne->xpath($lang);
		$doxologie.= "<tr><td class=\"gauche\">".$la[0]."</td><td class=\"droite\">".$ver[0]."</td></tr>";
	
	}
	return $doxologie;
}
/*
function initium($mp3,$lang) {
	$initium.="
	<div class=\"gauche\">".mp3Player($mp3)."&nbsp;</div>
	<div class=\"droite\">&nbsp;</div>";
	$fp = fopen ("sources/initium.csv","r","1");
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna=$data[1];
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		
		if($latin!="") $initium.="
		<div class=\"gauche\">$latin</div>
		<div class=\"droite\">$verna</div>";
  	}
	@fclose ($fp);
	
	return $initium;
}
*/
function utf($string) {
$string1=str_replace("é", "&eacute;",$string);
$string2= str_replace("è", "&egrave;",$string1);
$string3= str_replace("ê", "&ecirc;",$string2);
$string4= str_replace("ú", "&uacute;",$string3);
$string5= str_replace("ù", "&ugrave;",$string4);
$string6= str_replace("û", "&ucirc;",$string5);
$string7= str_replace("í", "&iacute;",$string6);
$string8= str_replace("î", "&icirc;",$string7);
$string9= str_replace("ï", "&iuml;",$string8);
$string10= str_replace("á", "&aacute;",$string9);
$string11= str_replace("à", "&agrave;",$string10);
$string12= str_replace("â", "&acirc;",$string11);
$string13= str_replace("æ", "&aelig;",$string12);
$string14= str_replace("ó", "&oacute;",$string13);
$string15= str_replace("ô", "&ocirc;",$string14);
$string16= str_replace("", "&oelig;",$string15);
$string17= str_replace(" ", "&nbsp;",$string16);
$string18= str_replace("", "&#146;",$string17);
$string19= str_replace("«", "&#171;",$string18);
$string20= str_replace("»", "&#187;",$string19);
$string21= str_replace("ç", "&ccedil;",$string20);
$string22= str_replace("ë", "&euml;",$string21);
$string23= str_replace("-", "-",$string22);
$string24= str_replace("ý", "&yacute;",$string23);
$string25= str_replace("°", "e",$string24);
//$string26= str_replace("Æ", "&Aelig;",$string25);
$string26= str_replace("", "&#8224;",$string25);
$string27= str_replace("É", "&Eacute;",$string26);
$string28= str_replace("", "&#151;",$string27);
$string29= str_replace("œ", "&#x153;",$string28);
return $string29;

}

function toUTF8($string){
$from = mb_detect_encoding($string);
if ($from != 'UTF-8') {
$string = mb_convert_encoding($string, 'UTF-8', $from);
}
}

function pater($lang) {
	$row=0;	
	$xml=simplexml_load_file("http://92.243.24.163/wp-content/plugins/liturgia/sources/PATER.xml"); 
	$la=$xml->xpath('//ligne//la');
	$expr="//ligne//".$lang;
	$ver=$xml->xpath($expr);
	$pater="<tr>";
	$v=0;
	while($la[$v]) {
		$pater.="<tr><td class=\"gauche\">".$la[$v]."</td>";
		$pater.="<td class=\"droite\">".$ver[$v]."</td></tr>";
		$v++;
	}
	return $pater."</tr>";	
}
function renvoi ($mp3,$lang) {
	$fp = fopen ("sources/renvoi.csv","r","1");
	$r=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
		$latin=$data[0];
		if ($lang=="fr") $verna="$data[1]";
		if ($lang=="en") $verna=$data[2];
		if ($lang=="ar") $verna="<div align=\"right\">$data[3]</div>";
		if($r==9) $renvoi.="
	<div class=\"gauche\">".mp3Player($mp3)."</div>";
	$renvoi.="<div class=\"droite\">&nbsp;</div>";
		if($latin!="") $renvoi.="
		<div class=\"gauche\">$latin</div>
		<div class=\"droite\">$verna</div>";
  	$r++;
	}
	@fclose ($fp);
	
	return $renvoi;
}


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




function affiche_nav($date,$office) {
    /*
    //INITIALISATION
  $jour=datets("");
  $date=$jour['AAAAMMJJ'];
  $lang=$_GET['lang'];
  $option=$_GET['option'];
  $task=$_GET['task'];
	$q=$_GET['q'];
		
	
  if(!$task) $task="affiche";
  if(!$lang) $lang=fr;
    
    
    $offices=array("p","Martyrologe","invitatoire","Lectures","laudes","tierce","sexte","none","vepres","complies","s");

    for($o=0;$offices[$o];$o++) {	 
      if ($office==$offices[$o]) {
	$officeactuel=$o;
	break;
      }
    }
  
$suivant = $offices[$officeactuel+1]; $precedent = $offices[$officeactuel-1];

$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
//print"<br> day = ".$day;
if($day==-1) $day=time();
//$dts=mktime(12,0,0,$mense,$die,$anno);
$dtsmoinsun=$day-60*60*24;
$dtsplusun=$day+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);

$dsuiv=$day+60*60*24;
$dprec=$day-60*60*24;

$date_suiv=$do;
$date_prec= $do;
if ($suivant=="s") {
	$suivant = "invitatoire";
	$date_suiv=date("Ymd",$dsuiv);
}

if ($precedent=="p") {
	$precedent = "complies";
	$date_prec= date("Ymd",$dprec);
}
$nav.="<center> <a href=?affiche=1&lang=fr&option=$option&date=$date&office=$office&task=$task&edition=".$_GET['edition'].">Français</a> - <a href=?affiche=1&lang=en&option=$option&date=$date&office=$office&task=$task>English</a> - <a href=?affiche=1&lang=ar&option=$option&date=$date&office=$office&task=$task>عربي</a></center>";

$auth=false;
if($GLOBALS['user']->roles[2]=="authenticated user") $auth=true;

//if ($auth) 
global $current_user;
get_currentuserinfo();
if($current_user->user_login) {
$nav.="<p><center> 
<a href=?affiche=1&lang=$lang&option=edit&date=$date&office=$office&mois_courant=$mense>Editer</a>"; /* | 
<a href=?affiche=1&lang=$lang&option=correction_ordo&date=$date&office=$office&mois_courant=$mense>Correction de l'ordo</a>

}
print"</center>";

$nav.="<center><a href=\"?affiche=1&date=$hier&office=$office&mois_courant=$mense&an=$anno&lang=$lang&edition=".$_GET['edition']."\"><<</a>|";
$nav.="<a href=\"?affiche=1&date=$date_prec&office=$precedent&mois_courant=$mense_prec&an=$anno_prec&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\"><</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=Martyrologe&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\">Martyrologe</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=invitatoire&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Invitatoire</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=osb_vigiles&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Vigiles (OSB) </a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=lectures&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Lectures</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=laudes&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\">Laudes</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=tierce&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\">Tierce</a>|";
$nav.="<a href=\"?affiche=1&date=$date&office=messe&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\">Messe</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=sexte&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Sexte</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=none&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">None</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=vepres&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Vêpres</a>|";
//$nav.="<a href=\"?affiche=1&date=$date&office=complies&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task\">Complies</a>|";
$nav.="<a href=\"?affiche=1&date=$date_suiv&office=$suivant&mois_courant=$mense_suiv&an=$anno_suiv&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\">></a>|";
$nav.="<a href=\"?affiche=1&date=$demain&office=$office&mois_courant=$mense&an=$anno&lang=$lang&option=$option&task=$task&edition=".$_GET['edition']."\"> >></a></center>";
return $nav;
*/
}
/*
function oraison($latin,$verna,$lang,$ref,$id) {
    
	$oraison.="
	<div class=\"gauche\"><font color=red><center>Oratio.".affiche_editeur($ref,"lat")."</center></font></div>";
	     
	if($lang=="fr") {$oraison.="<div class=\"droite\"><font color=red><center>Oraison.".affiche_editeur($ref,$lang)."</center></font>".affiche_editeur($ref,$lang)."</div>";
	} 
	  
	if ((substr($latin,-14))==" Per Dóminum.") {
		$latin=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
		if ($lang=="fr") $verna.=" Par notre Seigneur Jésus-Christ, Ton Fils, qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
     
	if ((substr($latin,-11))==" Qui tecum.") {
	        $latin=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
	    	if ($lang=="fr") $verna.=" Lui qui vit et règne avec Toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}

	if ((substr($latin,-11))==" Qui vivis.") {
	        $latin=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$latin);
	    	if ($lang=="fr") $verna.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	}
	    
	$oraison.="<div class=\"gauche\">".$latin."</div>";
	$oraison.="<div class=\"droite\">$verna </div>";
	
  return $oraison;
}
*/

function oratio($ref,$lang) {

$option=$_GET['option'];
$ref=no_accent($ref);
$refL="/wp-content/plugins/liturgia/sources/propres/xml/".$ref.".xml";
$xml = @simplexml_load_file("http://92.243.24.163/".$refL); // or die("Erreur : ".$refL);

$la=@$xml->xpath('//ligne//la');
$ver=@$xml->xpath('//ligne//'.$lang); 

	
	if ((substr($la[0],-14))==" Per Dóminum.") {
		$la[0]=str_replace(" Per Dóminum.", " Per Christum Dóminum nostrum.",$la[0]);
		$ver[0].=get_traduction(" Per Christum Dóminum nostrum.", $lang);
	}
	if ((substr($la[0],-14))==" Per Christum.") {
		$la[0]=str_replace(" Per Christum.", " Per Christum Dóminum nostrum.",$la[0]);
		$ver[0].=get_traduction(" Per Christum Dóminum nostrum.", $lang);
	}
    
	if ((substr($la[0],-11))==" Qui vivit.") {
	    $la[0]=str_replace(" Qui tecum.", " Qui vivit et regnat in sæcula sæculórum.",$la[0]);
	    $ver[0].=get_traduction(" Qui vivit et regnat in sæcula sæculórum.", $lang);
	}
	 
	if ((substr($la[0],-11))==" Qui tecum.") {
	    $la[0]=str_replace(" Qui tecum.", " Qui vivit et regnat in sæcula sæculórum.",$la[0]);
	    $ver[0].=get_traduction(" Qui vivit et regnat in sæcula sæculórum.", $lang);
	}

	if ((substr($la[0],-11))==" Qui vivis.") {
	    $la[0]=str_replace(" Qui vivis.", " Qui vivis et regnas in sæcula sæculórum.",$la[0]);
	    $ver[0].=get_traduction(" Qui vivis et regnas in sæcula sæculórum.", $lang);
	}

	$oratio="<tr><td class=\"gauche\">".$la['0']."</td>";
	$oratio.="<td class=\"droite\">".$ver['0']."</td></tr>";
	
	return $oratio;

}

function collecte($ref,$lang) {
	if(!$lang) $lang=$GLOBALS['lang'];
	if(!$lang) $lang="fr";
	$refL="/wp-content/plugins/liturgia/sources/propres/xml/".$ref.".xml";    
	$oraison="<tr>
	<td class=\"gauche\"><font color=red><center>Oratio</center></font></td>";
	 
	if($lang=="fr") {
		$oraison.="<td class=\"droite\"><font color=red><center>Oraison</center></font></td></tr>";
	} 
	  
	
	//print $refL;
	$xml = @simplexml_load_file("http://92.243.24.163/".$refL);// or die("Erreur : ".$refL);
	//print"<br>OPEN : "."sources/".$ref.".csv";

	$la=@$xml->xpath('//ligne//la');
	$ver=@$xml->xpath('//ligne//'.$lang); 
	
	  
	if ((substr($la[0],-14))==" Per Dóminum.") {
		$la[0]=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
		$ver[0].=get_traduction(" Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.", $lang);
	}
     
	if ((substr($la[0],-11))==" Qui tecum.") {
	    $la[0]=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
	    $ver[0].=get_traduction(" Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.", $lang);
	}

	if ((substr($la[0],-11))==" Qui vivis.") {
	    $la[0]=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$la[0]);
	    $ver[0].=get_traduction(" Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.", $lang);
	}
	    
	$oraison.="<tr><td class=\"gauche\">".$la['0']."</td>";
	$oraison.="<td class=\"droite\">".$ver['0']."</td></tr>";  

  return $oraison;
}





function affiche_texte($ref,$lang="fr") {
	//return;
//$option=$_GET['option'];
$aff="";
$refL="/wp-content/plugins/liturgia/sources/".$ref.".xml";
	 print"\r\n refL = ".$refL;
     $xml = simplexml_load_file("http://92.243.24.163/".$refL);// or die("<br>Error: Cannot create object : <a href=\"$refL\">$refL</a>");
	// print_r($xml);
     
     //$ref="LEC_".no_accent($ref);
	 

	 		
foreach(@$xml->children() as $ligne){
		$la=@$ligne->xpath('la');
		$ver=@$ligne->xpath($lang);
	
		if($ligne->style) {
			$aff.= "
			<tr><td class=\"gauche ".$ligne->style."\">".$la[0]."</td>
			<td class=\"droite ".$ligne->style."\">".$ver[0]."</td></tr>";
		}
		else	{
		if($la && $ver)	$aff.= "
			<tr><td class=\"gauche\">".$la[0]."</td>
			<td class=\"droite\">".$ver[0]."</td></tr>";
		}
	
	}
$aff=rougis_verset($aff);
return $aff;	
}



?>