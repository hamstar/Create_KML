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
            array(1, 1, 'Id'),
            array(1, '<b>1</b>', 'Id'),
        );
    }

    /**
     * @dataProvider setGetProvider
     */
    public function testSetGetOnStyle($assert, $value, $func)
    {
        $style = $this->kml->createStyle();

        $method = "set{$func}";
        $resp   = $style->$method($value);

        // test fluent interface
        $this->assertEquals('XML_KML_Style', get_class($resp));

        // test if XML_KML_Common::sanitize(), etc. worked
        $method = "get{$func}";
        $this->assertEquals($assert, $style->$method());
    }
}