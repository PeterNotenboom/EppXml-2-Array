<?php

require_once('Xml2Array.class.php');

// Check an invalid XML
$xml_string = file_get_contents('epp_examples/invalid.xml');

//========= getArray =========//
$test = Xml2Array::getArray($xml_string);
if($test != array()) { print_r($test); }
else {	echo "Oops, invalid xml, or just empty\n"; }

//========= getNamespaces =========//
$test2 = Xml2Array::getNamespaces($xml_string);
if($test2 !== false) { print_r($test2); }
else { echo "Oops, invalid xml\n"; }

//========= getArrayNS =========//
$test3 = Xml2Array::getArrayNS($xml_string, 'sidn-ext-epp');
if($test3 != array()) { print_r($test3); }
else { echo "Namespace not found, or invalid xml\n"; }

?>