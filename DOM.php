<?php

$xmldict = new SimpleXMLElement('<dictionary><a/><b/><c/></dictionary>');
$kitty   = new SimpleXMLElement('<cat><sound>meow</sound><texture>fuzzy</texture></cat>');

// Create new DOMElements from the two SimpleXMLElements
$domdict = dom_import_simplexml($xmldict->c);
$domcat  = dom_import_simplexml($kitty);

// Import the <cat> into the dictionary document
$domcat  = $domdict->ownerDocument->importNode($domcat, TRUE);

// Append the <cat> to <c> in the dictionary
$domdict->appendChild($domcat);

// We can still use SimpleXML! (meow)
echo $xmldict->c->cat->sound;
echo $xmldict->asxml();
?>
