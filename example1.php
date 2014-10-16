<?php

require_once('Xml2Array.class.php');

$xml_string = file_get_contents('epp_examples/domain-info.xml');

Xml2Array::loadXML($xml_string);

print_r( Xml2Array::getArray() );
print_r( Xml2Array::getNamespaces() );
print_r( Xml2Array::getArrayNS('keysys') );

//Added for v1.1:
print_r( Xml2Array::getArrayElement('domain', 'pw', true ) ); //Adding true assumes you already know there's only 1 tag

?>