<?php

require_once('Xml2Array.class.php');

// Check an invalid XML
$xml_string = file_get_contents('epp_examples/invalid.xml');

if( Xml2Array::loadXML($xml_string) ) {
	echo "Xml file loaded.\n";
}
else {
	echo "Load failed. Invalid XML?\n";
}

//========= getArray =========//
$test = Xml2Array::getArray();
if($test != array()) { print_r($test); }
else {	echo "Oops, invalid xml, or just empty\n"; }

//========= getNamespaces =========//
$test2 = Xml2Array::getNamespaces();
if($test2 !== false) { print_r($test2); }
else { echo "Oops, invalid xml\n"; }

//========= getArrayNS =========//
$test3 = Xml2Array::getArrayNS('sidn-ext-epp');
if($test3 != array()) { print_r($test3); }
else { echo "Namespace not found, or invalid xml\n"; }

$is_valid_xml = simplexml_load_string($xml_string);
if($is_valid_xml) {
	echo "Yes, valid XML\n";
}
else {
	echo "No, not valid XML\n";
}


?>