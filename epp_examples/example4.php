<?php

//Checking if CDATA works.

require_once('../Xml2Array.class.php');

$xml_string = file_get_contents('xml/cdata-test.xml');

Xml2Array::loadXML($xml_string);

print_r( Xml2Array::getArray() );

?>