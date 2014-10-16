<?php

require_once('Xml2Array.class.php');

$xml_string = file_get_contents('epp_examples/domain-info.xml');

print_r( Xml2Array::getArray($xml_string) );
print_r( Xml2Array::getNamespaces($xml_string) );
print_r( Xml2Array::getArrayNS($xml_string, 'keysys') );


?>