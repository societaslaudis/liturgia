<?php

for ($n=1;$n<35;$n++){
$PA = 'perannum_'.$n;
 
	foreach (glob("sources/propres/".$PA."-*.xml") as $filename) {
		echo "$filename  \r\n";
		$SXE=simplexml_load_file($filename);
		if($SXE->messe){
			$SXE->messe->addChild("IN_L");
			$SXE->messe->IN_L->addAttribute('id', "IN_L_".$PA);
			if(!$SXE->messe->COL) {
				$SXE->messe->addChild("COL");
				$SXE->messe->COL->addAttribute('id', "COL_".$PA);
			}
			if(!$SXE->messe->SO) {
				$SXE->messe->addChild("SO");
				$SXE->messe->SO->addAttribute('id', "SO_".$PA);
			}
			$SXE->messe->addChild("CO_L");
			$SXE->messe->CO_L->addAttribute('id', "CO_L_".$PA);
			if(!$SXE->messe->PC) {
				$SXE->messe->addChild("PC");
				$SXE->messe->PC->addAttribute('id', "PC_".$PA);
			}
			print_r($SXE->messe);
			$SXE->asxml($filename);
		}
	}
}

?>
