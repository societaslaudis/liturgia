<?php
    $xml=simplexml_load_file("+Martyrologe romain.xml");
	$select=$xml->xpath("//sect2");
	$output="<xml>";
	$jourid=0;
	
	foreach ($select as $sect) {
		print $sect->title."\r\n";
		$o= cherche($sect->title);
		if($o) {
			//$jourid++;
			$output.="\r\n<jour id='".$o."'>\r\n<title>".$sect->title."</title>";
		
			//else $output.="<jour><title>".$sect->title."</title>";
			$para = $sect->xpath("para");
			foreach ($para as $notice) {
				//print $notice."\r\n";
				$output.="\r\n<notice>".$notice."</notice>";
			}
			$output.="\r\n</jour>";
		}
	}
	$output.="</xml>";
	$mar=simplexml_load_string($output);
	$mar->asxml("martyrologeromain.xml");
	
	
	function cherche($tit) {
		$mois=array(" janvier"," février"," mars"," avril"," mai"," juin"," juillet"," août"," septembre"," octobre"," novembre"," décembre");
		$jour=array(" 1er "," 2 "," 3 "," 4 "," 5 "," 6 "," 7 "," 8 "," 9 "," 10 "," 11 "," 12 "," 13 "," 14 "," 15 "," 16 "," 17 "," 18 "," 19 "," 20 "," 21 "," 22 "," 23 "," 24 "," 25 "," 26 "," 27 "," 28 "," 29 "," 30 "," 31 ");
		//print_r($mois);
		$jnum=1;
		foreach ($jour as $j) {
			if(stristr($tit,$j)) $output=$jnum."-";
			$jnum++;
			
		}
		$num=1;
		foreach ($mois as $m) {
			if(stristr($tit,$m)) return $output.$num;
			$num++;
			
		}
		return false;
		
	}
?>