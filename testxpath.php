<?php

$thisSXE= simplexml_load_file("sources/propres/perannum_34-2.xml");
//$rp=$thisproprexml->xpath("//messe");
// '/liturgia/RB_osb_vigiles/@id')

/*
 * foreach (array_expression as $value){
    //commandes
   }
 * La première forme passe en revue le tableau array_expression. 
 * À chaque itération, la valeur de l'élément courant est assignée à $value et le pointeur interne de tableau est avancé d'un élément
 *  (ce qui fait qu'à la prochaine itération, on accédera à l'élément suivant).
 */
 $parite="impaire";
 $ABC="A";
$SXEmesse=$thisSXE->xpath("//messe");
//print_r($SXEmesse);
foreach ($SXEmesse as $messe) {
		$output="<messe>";
		$output.="<Intitule_messe>".$messe->intitule."</Intitule_messe>\r\n";
		
		$IN=$messe->xpath("IN[@id]");
		//print_r($IN);
		foreach ($IN as $item) $output.="<IN>".$item['id']."</IN>\r\n";
		
		$COL=$messe->xpath("COL[@id]");
		//print_r($COL);
		foreach ($COL as $item) $output.="<COL>".$item['id']."</COL>\r\n";
		
		$LEC=$messe->xpath("LEC[@id]");
		//print_r($LEC);
		foreach ($LEC as $item) $output.="<LEC>".$item['id']."</LEC>\r\n";
		$LEC=$messe->xpath("LEC/".$parite."[@id]");
		print "xpath(LEC[@id]/".$parite;
		print_r($LEC);
		foreach ($LEC as $item) $output.="<LEC>".$item['id']."</LEC>\r\n";
		$LEC=$messe->xpath("LEC/".$ABC."[@id]");
		foreach ($LEC as $item) $output.="<LEC>".$item['id']."</LEC>\r\n";
		
		$PS1=$messe->xpath("PS1[@id]");
		//print_r($PS1);
		foreach ($PS1 as $item) $output.="<PS1>".$item['id']."</PS1>\r\n";
		
		
		
		$output.="</messe>";
}

print $output ;

?>
