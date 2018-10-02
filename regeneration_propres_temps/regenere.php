<?php
    $xmlT1="
    <liturgia>
    	<laudes>
			<ant1>antienne 1.0</ant1>
			<ant2>antienne 1.0</ant2>  
			<ant3>antienne 1.0</ant3>        	
    	</laudes>
    	<messe>
    		<IN>IN 1.0</IN>
    		<AL>AL 1.0</AL>
    		<CO>CO 1.0</CO>
    	</messe>
    	<vepres>
    		<ant1>antienne 1.0</ant1>
			<ant2>antienne 1.0</ant2>  
			<ant3>antienne 1.0</ant3>  
		</vepres>
    </liturgia>";
 
 
     $xmlT2="
    <liturgia>
    	<laudes>
			<ant1>antienne 2.0</ant1>
			<ant2>antienne 2.0</ant2>  
			<ant3>antienne 2.0</ant3>        	
    	</laudes>
    	<messe>
    		<IN>IN 2.0</IN>
    		<AL>AL 2.0</AL>
    		<AL><c>AL machin</c></AL>
    		<CO>CO 2.0</CO>
    	</messe>
    	<vepres>
    		<ant1>antienne 2.0</ant1>
			<ant2>antienne 2.0</ant2>  
			<ant3>antienne 2.0</ant3>  
		</vepres>
    </liturgia>";   
    
	   $xmlT3="
    <liturgia>
    	<laudes>
			<ant1>antienne 3.0</ant1>
			<ant2>antienne 3.0</ant2>  
			<ant3>antienne 3.0</ant3>        	
    	</laudes>
    	<messe>
    		<IN>IN 3.0</IN>
    		<AL>AL 3.0</AL>
    		<CO>CO 3.0</CO>
    		<CO><a>CO truc</a></CO>
    	</messe>
    	<vepres>
    		<ant1>antienne 3.0</ant1>
			<ant2>antienne 3.0</ant2>  
			<ant3>antienne 3.0</ant3>  
		</vepres>
    </liturgia>";  
    
    
 $sxe1=simplexml_load_string($xmlT1);
 $sxe2=simplexml_load_string($xmlT2);
 $sxe3=simplexml_load_string($xmlT3);
 print_r(ajout($sxe1,$sxe2));
  
  function ajout($sxeBase,$sxeAjout){
  
	foreach ($sxeAjout->children() as $child) {
		$name1= $child->getName()."\r\n";	
		foreach($child->children() as $child2){
			$name2=$child2->getName()."\r\n";	
				foreach($child2->children() as $child3){
				$name3=$child3->getName()."\r\n";
				
				foreach($child3->children() as $child4){
				$name4=$child4->getName()."\r\n";	
					if($sxeBase->$name1->$name2->$name3->$name4){
						$sxeBase->$name1->$name2->$name3->$name4=$sxeAjout->$name1->$name2->$name3->$name4;
				}
				}
			
			}
		}
  }
  return $sxeBAse;
  }
?>