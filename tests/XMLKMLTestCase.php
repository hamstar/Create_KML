<?php
require_once 'XML/KML/Create.php';
require_once 'PHPUnit/Framework/TestCase.php';

class XMLKMLCreateTestCase extends PHPUnit_Framework_TestCase
{
    protected $kml;

    public function setUp()
    {
        // Create a new KML object
        $this->kml = new XML_KML_Create();
    }

    /**
     * provide assertion and values, and callable setter
     */
    public static function setGetProvider()
    {
        return array(
            array(1, 1, 'setId'),
            array(1, '<b>1</b>', 'setId'),
        );
    }

    /**
     * @dataProvider setGetProvider
     */
    public function testSetGetOnStyle($assert, $value, $func)
    {
        $style = $this->kml->createStyle();

        $resp  = $style->$func();
        $this->assertEquals('XML_KML_Style', get_class($resp));
        $this->assertEquals($assert, $value);
    }
}