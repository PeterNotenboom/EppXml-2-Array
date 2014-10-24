<?php

require_once('../Xml2Array.class.php');

$xml_string = file_get_contents('xml/domain-delete-error.xml');

Xml2Array::loadXML($xml_string);

print_r( Xml2Array::getArray() );
print_r( Xml2Array::getNamespaces() );
print_r( Xml2Array::getArrayNS('sidn-ext-epp') );
?>