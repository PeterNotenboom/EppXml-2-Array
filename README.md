EppXml-2-Array v1.3
===================

An EPP (http://en.wikipedia.org/wiki/Extensible_Provisioning_Protocol), with Namespace support, to a simple Array.
Still usable for normal XML too. CDATA is supported.

Why not use xyz?
----

For regular XML you can use this (probably) fine:
```php
$xml = simplexml_load_string($xmlstring);
$json = json_encode($xml);
$array = json_decode($json,TRUE);
```
But it doesn't work "out of the box" with namespaces.
Also, simplexml_load_string somehow removes certain attributes.
For example, if your EPP had:
```xml
<domain:contact type="billing">P-ABC120</domain:contact>
```
It will remove the "type" attribute. And for EPP any missing information makes those methods unusable.


How to use
----
Notice: Error handling isn't perfect (yet). Valid EPP isn't valid XML somehow ('no DTD found' errors with DOMDocument::validate() ) See example3.php for all the bits of error handling it has. Also, I'm not 100% sure simplexml_load_string() validates the complete XML.

First, load the XML:
```php
Xml2Array::loadXML($xml_string);
//or
Xml2Array::loadXML(file_get_contents('somefile.xml'));
```
Get the whole array from your complete EPP string:
```php
print_r( Xml2Array::getArray() );
```
Get all the Namespace prefixes + URI's as an array:
```php
print_r( Xml2Array::getNamespaces() );
```
Get a part of the EPP in array by giving the prefix:
```php
print_r( Xml2Array::getArrayNS('contact') );
```
##### Added in v1.1
Too lazy to look where in the array/xml a tag is? Or the tag could be changing in different xml files?
See example1.php, use it like this:
```php
print_r( Xml2Array::getArrayElement('domain', 'pw', true ) );
```

##### Added in v1.3
Want to get an attribute like:
```xml
<result code="1000">...
```
See example1.php, use it like this:
```php
print_r( Xml2Array::getArrayAttribute(null, 'result', 'code', true) );
```
Simple as that.

License
----
MIT
