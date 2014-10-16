<?php

/**
 * Epp2Array, EPP/XML to a simple readable (usable) array
 *
 * An EPP (http://en.wikipedia.org/wiki/Extensible_Provisioning_Protocol), with Namespace support, to a simple Array
 * Still usable for normal XML too. CDATA and such may not work, not tested.
 * Also, there's hardly any error handling, so be careful of that
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
		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->loadXML($xml_raw);

		return self::processArray($xml);
	}

	/**
	  * Return all namespaces in an Array, might be useful somehow
	  * Key = prefix, value = uri
	  * @param string $xml_raw
	  * @return array
	  */
	public static function getNamespaces($xml_raw) {
		$xml = simplexml_load_string($xml_raw);
		return $xml->getNameSpaces(true);
	}

	/**
	  * Return only the partial namespace/prefix array of the XML. Call getNamespaces() to see which namespaces there are.
	  * Returns false if there's no such namespace, use !== false to check
	  * @param string $xml_raw
	  * @param string $namespace
	  * @return array|boolean
	  */
	public static function getArrayNS($xml_raw, $namespace) {
		$result = array();

		$namespaceURIS = self::getNamespaces($xml_raw);
		if(isset($namespaceURIS[$namespace])) {

			$dom = new DOMDocument('1.0', 'utf-8');
			$dom->loadXML($xml_raw);
			$namespaces = $dom->getElementsByTagNameNS( $namespaceURIS[$namespace] , '*');
			if($namespaces->length > 0) {
				//Todo: foreach is kinda overkill. But EPP isn't that large. (added a break for now)
				foreach ($dom->getElementsByTagNameNS( $namespaceURIS[$namespace] , '*') as $element) {
					$elements[] = self::processArray($element);
					break;
				}
				$result = $elements[0];
			}
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	  *	Processes the xml DOM, nodes and namespaces and turns it into an array.
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
