<?php
//fonction pour re-ecrire les url
function format_url($chaine) { 

	// en minuscule
    $chaine=strtolower($chaine);
	
	// supprime les caracteres speciaux
    $accents = Array("/�/", "/�/", "/�/","/�/", "/�/", "/�/", "/�/","/�/","/�/","/�/", "/�/", "/�/", "/�/", "/�/", "/�/", "/�/", "/�/", "/�/", "/�/", "/�/");
    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
    $chaine = preg_replace($accents, $sans, $chaine);  
    $chaine = preg_replace('#[^A-Za-z0-9]#', '-', $chaine);
 
   // Remplace les tirets multiples par un tiret unique
   $chaine = ereg_replace( "\-+", '-', $chaine );
   
   // Supprime le dernier caract�re si c'est un tiret
   $chaine = rtrim( $chaine, '-' );
 
    while (strpos($chaine,'--') !== false) 
		$chaine = str_replace('--', '-', $chaine);
 
    return $chaine; 
	
}
?>