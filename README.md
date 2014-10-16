EppXml-2-Array
==============

An EPP (http://en.wikipedia.org/wiki/Extensible_Provisioning_Protocol), with Namespace support, to a simple Array.
Still usable for normal XML too. CDATA and such may not work, not tested.

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
It will remove "type". And for EPP any missing information makes this unusable.

##### It has no good error handling (yet), so you might have to edit this class to your own needs.


License
----
MIT
