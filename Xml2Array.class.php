<?php

/**
 * Epp2Array, EPP/XML to a simple readable (usable) array
 *
 * An EPP (http://en.wikipedia.org/wiki/Extensible_Provisioning_Protocol), with Namespace support, to a simple Array
 * Still usable for normal XML too. CDATA and such may not work, not tested.
 * Also, there's hardly any (good) error handling so be careful of that. Mainly because of 'no DTD' errors (wont validate)
 * @author Peter Notenboom <peter@petern.nl>
 * @version 1.0
 * @package Xml2Array
 */

/**
 * Xml2Array Class
 * @package Xml2Array
 */

class Xml2Array {

	/**
	  * Return whole Array by giving a complete XML $xml_raw string
	  * @param string $xml_raw
	  * @return array
	  */
	public static function getArray($xml_raw = '') {
		libxml_use_internal_errors(TRUE);
		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->loadXML($xml_raw);
		//if ($xml->validate()) { //Warning: DOMDocument::validate(): no DTD found!
		return self::processArray($xml);
	}

	/**
	  * Return all namespaces in an Array, might be useful somehow
	  * Key = prefix, value = uri
	  * @param string $xml_raw
	  * @return array
	  */
	public static function getNamespaces($xml_raw) {
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xml_raw);
		if($xml) {
			return $xml->getNameSpaces(true);
		}
		else {
			//$errors = libxml_get_errors();
			//libxml_clear_errors();
			return false;
		}
	}

	/**
	  * Return only the partial namespace/prefix array of the XML. Call getNamespaces() to see which namespaces there are.
	  * Returns an empty array if there's nothing found.
	  * @param string $xml_raw
	  * @param string $namespace
	  * @return array
	  */
	public static function getArrayNS($xml_raw, $namespace) {
		libxml_use_internal_errors(true);
		$result = array();

		$namespaceURIS = self::getNamespaces($xml_raw);
		if(isset($namespaceURIS[$namespace])) {

			$xml = new DOMDocument('1.0', 'utf-8');
			$xml->loadXML($xml_raw);
			//if ($xml->validate()) { //Warning: DOMDocument::validate(): no DTD found!
			$namespaces = $xml->getElementsByTagNameNS( $namespaceURIS[$namespace] , '*');
			if($namespaces->length > 0) {
				//Todo: foreach is kinda overkill. But EPP isn't that large. (added a break for now)
				foreach ($xml->getElementsByTagNameNS( $namespaceURIS[$namespace] , '*') as $element) {
					$elements[] = self::processArray($element);
					break;
				}
				$result = $elements[0];
			}
			return $result;
		}
		else {
			return array();
		}
	}

	/**
	  * Processes the xml DOM, nodes and namespaces and turns it into an array.
	  * Largely based on: http://php.net/manual/en/book.dom.php#93717
	  * @param object $root DOMDocument
	  * @return array
	  */
	private static function processArray($root) {
		$result = array();

		if ($root->hasAttributes()) {
			$attrs = $root->attributes;
			foreach ($attrs as $attr) {
				$result['@attributes'][$attr->name] = $attr->value;
			}
		}
		if ($root->hasChildNodes()) {
			$children = $root->childNodes;
			if ($children->length == 1) {
				$child = $children->item(0);
				if ($child->nodeType == XML_TEXT_NODE) {
					$result['_value'] = $child->nodeValue;
					if ( count($result) == 1 ) {
						return $result['_value'];
					}
					else {
						return $result;
					}
				}
			}
			$groups = array();
			foreach ($children as $child) {
				$childNode = array();
				if (!isset($result[$child->nodeName])) {
					$childNode = self::processArray($child);
					//Needs to return atleast 1 result
					if (count($childNode) >= 1) {
						$result[$child->nodeName] = $childNode;
					}
				} else {
					if (!isset($groups[$child->nodeName])) {
						$result[$child->nodeName] = array($result[$child->nodeName]);
						$groups[$child->nodeName] = 1;
					}
					$childNode = self::processArray($child);
					//Needs to return atleast 1 result
					if (count($childNode) >= 1) {
						$result[$child->nodeName][] = $childNode;
					}
				}
			}
		}
		return $result;
	}
}

?>