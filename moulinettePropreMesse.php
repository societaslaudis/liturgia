<?php
$SXE=simplexml_load_file("temporal_a.xml");
//print_r($xml);
foreach ($SXE->children() as $celebration) {
	$SXECel=simplexml_load_file("sources/propres/".$celebration['id'].".xml");
	unset($SXECel->messe);
	
	
	$domCel = dom_import_simplexml($SXECel);
	print "\r\n **** ".$SXECel->LEC_1_impaire['id'];
	//print_r($celebration);
		$content="<messe>";
		$content.="<IN id='".$celebration->IN."'/>";
		if(stristr($celebration['id'], 'perannum_')) $content.="<COL id='COL_".stristr($celebration['id'], '-', true)."'/>";
		if ($SXECel->LEC_I->A) $content.="
			<LEC>
				<A id='LEC_".$SXECel->LEC_I->A['id']."'/>
				<B id='LEC_".$SXECel->LEC_I->B['id']."'/>
				<C id='LEC_".$SXECel->LEC_I->C['id']."'/>
			</LEC>";
		if(($SXECel->LEC_1_impaire!="")&&($SXECel->LEC_1_impaire==$SXECel->LEC_1_paire)) $content.="
		<LEC id='LEC_".$SXECel->LEC_1_impaire."'/>";
		elseif ($SXECel->LEC_1_impaire['id']) $content.="<LEC><impaire id='LEC_".$SXECel->LEC_1_impaire['id']."'/><paire id='LEC_".$SXECel->LEC_1_paire['id']."'/></LEC>";
		$content.="<PS1 id='".$celebration->PS1."'/>";
		print $content;
		if ($SXECel->LEC_II->A) $content.="<LEC2><A id='LEC_".$SXECel->LEC_II->A['id']."'/><B id='LEC_".$SXECel->LEC_II->B['id']."'/><C  id='LEC_".$SXECel->LEC_II->C['id']."'/></LEC2>";
		$content.="<PS2 id='".$celebration->PS2."'/>";
		if ($SXECel->EV->A) $content.="<EV><A id='EV_".$SXECel->EV->A['id']."'/><B id='EV_".$SXECel->EV->B['id']."'/><C id='EV_".$SXECel->EV->C['id']."'/></EV>";
		if ((string)$SXECel->EV) $content.="<EV id='EV_".$SXECel->EV."'/>";
		if ($SXECel->EV['id']) $content.="<EV id='EV_".$SXECel->EV['id']."'/>";
		$content.="<OF id='".$celebration->OF."'/>";
		if(stristr($celebration['id'], 'perannum_')) $content.="<SO id='SO_".stristr($celebration['id'], '-', true)."'/>";
		$content.="<CO id='".$celebration->CO."'/>";
		if(stristr($celebration['id'], 'perannum_')) $content.="<PC id='PC_".stristr($celebration['id'], '-', true)."'/>";
		$content.="</messe>";
		print $content."\r\n \r\n \r\n \r\n \r\n \r\n \r\n \r\n";
	$SXEContent=simplexml_load_string($content);
	$domContent  = dom_import_simplexml(simplexml_load_string($content));
	$dom  = $domCel->ownerDocument->importNode($domContent, TRUE);
	$domCel->appendChild($dom);
	
	echo $SXECel->asXML();
	$SXECel->asXML("sources/propres/".$celebration['id'].".xml");
	print"\r\n ****************************************************\r\n ";
}
?>
