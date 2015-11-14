<?php

namespace PN;

if (!class_exists('PN\Xml2Array')) {
    require_once dirname(__DIR__).'/src/Xml2Array.class.php';
}

class EPPXml2ArrayTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadXml()
    {
        $xml_string = file_get_contents(dirname(__DIR__).'/epp_examples/xml/domain-info.xml');
        $result = Xml2Array::loadXML($xml_string);

        $this->assertEquals($result, true);
    }

    public function testGetArray()
    {
        $result = Xml2Array::getArray();

        $this->assertArrayHasKey('epp', $result);
        $this->assertEquals($result['epp']['response']['result']['@attributes']['code'], 1000);
    }

    public function testGetNamespaces()
    {
        $result = Xml2Array::getNamespaces();

        $this->assertArrayHasKey('domain', $result);
        $this->assertEquals($result['domain'], 'urn:ietf:params:xml:ns:domain-1.0');
    }

    public function testGetArrayNS()
    {
        $result = Xml2Array::getArrayNS('keysys');

        $this->assertEquals(
            $result,
            array(
            'keysys:infData' => array(
            'keysys:renDate' => '2016-10-06T19:00:00.0Z',
            'keysys:domain-roid' => '1234567890_DOMAIN_COM-VRSN',
            'keysys:renewalmode' => 'DEFAULT',
            'keysys:transferlock' => 0,
            'keysys:transfermode' => 'DEFAULT',
            )
            )
        );
    }

    public function testGetArrayElement()
    {
        $result = Xml2Array::getArrayElement('domain', 'pw', true);

        $this->assertEquals($result, '5Kxyz2;@Y1U');
    }

    public function testGetArrayAttribute()
    {
        $result = Xml2Array::getArrayAttribute(null, 'result', 'code', true);

        $this->assertEquals($result, 1000);
    }
}
