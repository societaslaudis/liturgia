<?php
$dir_nom = '.';// dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
print"\r\n rename LEC_I_";

foreach(glob("LEC_I_*.xml") as $lien) {
print "\r\n $lien";
$new=str_replace("LEC_I_","LEC_",$lien);
if (rename($lien,$new)) print" OK, renommé en : ".$new;
else print " echec : pas renommé en ".$new;
/////////////ICI le code 
}




?>