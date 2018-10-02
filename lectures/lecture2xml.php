<?php
include ("drupal/sites/all/modules/liturgia/fonctions.php");

function hy2xml($ref) {
$output="<liturgia> ";
$fp = fopen ("drupal/sites/all/modules/liturgia/sources/".$ref,"r","1");
$l=0;
	while ($data = @fgetcsv ($fp, 1000, ";")) {
	$output.="<ligne id=\"$l\">\r";
	if($data[0]) $output.="<la>".$data[0]."</la>";
	if($data[1]) $output.="<fr>".$data[1]."</fr>";
	if($data[2]) $output.="<en>".$data[2]."</en>";
	if($data[3]) $output.="<ar>".$data[3]."</ar>";
	$output.="</ligne>\r";
	$ligne[$l]=$data[0];
	$l++;
	}
	@fclose($fp);
$output.="</liturgia>";

$sxe = new SimpleXMLElement($output);
$ref = str_replace(".csv", ".xml", $ref);
$ref = str_replace("hy_", "HY_", $ref);
$ref=no_accent($ref);
$sxe->asXML("drupal/sites/all/modules/liturgia/sources/".$ref);
}


$dir_nom = '.';// dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')


foreach(glob($dir_nom."*.csv") as $lien) {
echo "<li><a href=$dir_nom/$lien >$lien</a></li>n";
///////////// ICI le code pour le traitement des fichiers d'office
if ((substr($lien,0,2)=="hy")||(substr($lien,0,2)=="HY")) hy2xml($lien);
print"<br>".$lien -> XML;
echo "</ul>";
}







?>