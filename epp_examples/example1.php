<?php

require_once('../Xml2Array.class.php');

$xml_string = file_get_contents('xml/domain-info.xml');

Xml2Array::loadXML($xml_string);

print_r( Xml2Array::getArray() );
print_r( Xml2Array::getNamespaces() );
print_r( Xml2Array::getArrayNS('keysys') );

//Added for v1.1:
print_r( Xml2Array::getArrayElement('domain', 'pw', true ) ); //Adding true assumes you already know there's only 1 tag
print_r( Xml2Array::getArrayElement(null, 'result', true) );
print_r( Xml2Array::getArrayElement(null, 'msg', true ) ); //Just use '' or null for an empty namespace/root

//Added for v1.3:
print_r( Xml2Array::getArrayAttribute(null, 'result', 'code', true) ); //no namespace, <result code="1000">, true = only give first/one result back would give back "1000"

?>
