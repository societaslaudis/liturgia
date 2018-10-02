<?php
///// PARAMETRES
$annee=2016;
///////////////////////


include_once "cal2XML.php";
include_once "genere_calendarium.php";
include_once "tableau.php";


print"\r\n Début du script.";
$cal[0]=genere_calendarium($annee,"RE");
print"\r\n genere_calendarium($annee,RE)";

//$cal[1]=genere_calendarium($annee,"SWF");
//print"\r\n genere_calendarium($annee,SWF)";

//$cal[2]=genere_calendarium($annee,"SMK");
//print"\r\n genere_calendarium($annee,SMK)";
//print_r($cal[0]);
//file_put_contents("cal_RE.txt", $cal[0]);
cal2XML($cal,$annee);
print"\r\n cal2XML(cal,$annee);";

?>