<!DOCTYPE html>
<html lang="fr">
<head>

	<meta charset="UTF-8">
	</head>
	<body>
<?php

if(@$_GET['action']=="enr") {
	print"<table>";
	$val=$_POST['val'];
	foreach ($val as $modif)  {
		if($modif) print"<tr><td><b>".$modif."</td><td> -> </td><td>".str_replace ( "_" , "," , $modif )."</b></td>";
		if (rename ( "EV_".$modif , "EV_".str_replace ("_" ,",",$modif )))  print"<td>OK</td>";
		else print"<td>Echec</td>";
		print"</tr>";
	}
	print"</table>";
}


$i=0;
print"<table><form action=\"renomme_lectures_evangile.php?action=enr\" method=post> ";
foreach(glob("EV_*.xml") as $lien) {
print "<tr><td>$lien</td>";
///////////// ICI le code pour le traitement des fichiers d'office
//if ((substr($lien,0,2)=="hy")||(substr($lien,0,2)=="HY")) hy2xml($lien);
//print"<br>".$lien; quadragesima ASCENSIONE adventus pascha pascha IESU Pentecostes TRINITATIS CHRISTI

$lien = str_replace ( "EV_" , "" , $lien );
if ((strpos ( $lien , "_" )>0)&&(stristr($lien, 'perannum') === FALSE)&&(stristr($lien, 'jour') === FALSE)&&(stristr($lien, 'CHRISTI') === FALSE)&&(stristr($lien, 'TRINITATIS') === FALSE)&&(stristr($lien, 'Pentecostes') === FALSE)&&(stristr($lien, 'IESU') === FALSE)&&(stristr($lien, 'infraoctavamnativitas') === FALSE)&&(stristr($lien, 'pascha') === FALSE)&&(stristr($lien, 'quadragesima') === FALSE)&&(stristr($lien, 'adventus') === FALSE)&&(stristr($lien, 'ASCENSIONE') === FALSE)) {
	$newlien=	str_replace ( "_" , "," , $lien );
	print "<td><input name=\"val[$i]\" value=\"$lien\" type=checkbox CHECKED></td><td>-> à renommer en : EV_".$newlien."</td>\r\n";
	$i++;	
	}
	print"</tr>";
}
print"</table>
<input type=submit></form></table>";

?>
</body>
</html>