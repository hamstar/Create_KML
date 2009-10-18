<?php
/**
* Create a KML file
*
* Class for creating a KML file from a data source
* and outputing it to either a file or string
*  
* PHP version 5
*
* @category  XML
* @package   Create_KML
* @author    Robert McLeod <hamstar@telescum.co.nz>
* @copyright 2009 Robert McLeod
* @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
* @version   SVN: 1.0
* @link      ??
*
*/

spl_autoload_register(array('XML_KML_Create', 'autoload'));

/**
* Main class to add items to and create the KML
*
* @category XML
* @package  Create_KML
* @author   Robert McLeod <hamstar@telescum.co.nz>
* @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
* @link     ??
*/
class XML_KML_Create
{
    /**
    * The array of styles
    *
    * @var array
    * @access protected
    */
    protected $styles = array();
   
    /**
    * The array of places in their folders
    *
    * @var array
    * @access protected
    */
    protected $folders = array();
    
    /**
    * Empty constructor
    *
    */
    public function __construct()
    {
    }
    
    /**
    * Destructor
    *
    */
    public function __destruct()
    {
        $this->reset();
    }

    /**
     * Autoloader
     *
     * @param string $className The name of the class to load.
     *
     * @return boolean
     */
    public static function autoload($className)
    {
        static $path;

        if ($path === null) {
            $path = dirname(dirname(dirname(__FILE__)));
        }

        $file = $path . '/' . str_replace('_', '/', $className) . '.php';
        return require $file;
    }

    public function createPlace()
    {
        return new XML_KML_Place();
    }

    public function createStyle()
    {
        return new XML_KML_Style();
    }
    
    /**
    * Print the content header for a KML file or optionally an XML file
    * (so it can be viewed in a browser)
    *
    * @param bool $xml true will print xml header
    *
    * @access public
    * @return void
    */
    public function printHeader($xml = false)
    {
        if ($xml == false) {
            header('Content-type: application/vnd.google-earth.kml+xml');
        } else {
            header('Content-type: text/xml');
        }
    }
   
    /**
    * Adds an item to the KML data
    *
    * @param XML_KML_Common $item The object to add
    *
    * @return $this
    * @throws XML_KML_Exception When you inject something we don't know about.
    */
    public function addItem(XML_KML_Common $item)
    {
        // Switch which array to put the given item in
        switch ($item->type) {
        case 'place':
            $this->folders[$item->folder][] = $item;
            break;
               
        case 'style':
            $this->styles[] = $item;
            break;
               
        default:
            throw new XML_KML_Exception("Unsupported object.");
        }
        return $this;
    }
   
    /**
    * Creates the KML code from data given
    *
    * @access public
    * @return string
    */
    public function __toString()
    {
   
        // Set the xml version
        $xml_head = '<?xml version="1.0" encoding="UTF-8"?>';
        
        // Open a new KML doc
        $sxe = new SimpleXMLElement(
            '<kml xmlns = "http://earth.google.com/kml/2.1"></kml>'
        );
        
        // Put document in the kml
        $doc = $sxe->addchild('Document');
       
        // Set all the styles for the document
        foreach ($this->styles as $s) {
            $style = $doc->addChild('Style');
            $style->addAttribute('id', $s->id);
            
            $iconStyle = $style->addChild('IconStyle');
            $iconStyle->addAttribute('id', $s->iconid);
            
            $icon = $iconStyle->addChild('Icon');
            $icon->addChild('href', $s->iconhref);
        }
       
        // Set all the folders and places in each folder
        foreach ($this->folders as $f => $places) {
            if ($f != '**[root]**') {
                // Set the folder and folder name
                $folder = $doc->addChild('Folder');
                $folder->addChild('name', $f);
                $folder->addChild('open', 0);
               
                // Set all the placemarks in this folder
                foreach ($places as $p) {
                
                    // Add all the placemark details
                    $place = $folder->addChild('Placemark');
                    $place->addAttribute('id', $p->id);
                    $place->addChild('name', $p->name);
                    $place->addChild('description', $p->desc);
                    $place->addChild('styleUrl', $p->style);
                    
                    // Add coordinates information
                    $point = $place->addChild('Point');
                    $point->addChild('coordinates', $p->coords);
                }
            }
        }
       
        // Set all the root placemarks so they are not in a folder
        foreach ($this->folders['**[root]**'] as $p) {
                    
            // Add all the placemark details
            $place = $folder->addChild('Placemark');
            $place->addAttribute('id', $p->id);
            $place->addChild('name', $p->name);
            $place->addChild('description', $p->desc);
            $place->addChild('styleUrl', $p->style);
            
            // Add coordinates information
            $point = $place->addChild('Point');
            $point->addChild('coordinates', $p->coords);
                
        }
        
        // Put the xml into a string
        $kml = $sxe->asXML();
        
        // Kill $sxe to save memory
        $sxe = null;
        
        // Check that xml was returned
        if ($kml != false) {
            
            // Return the xml
            return $xml_head . $kml;
            
        }
        
    }

    /**
    * Clears all the data to free up memory
    *
    * @access public
    * @return void
    */
    public function reset()
    {
        $this->folders = null;
        $this->styles = null;
    }
}
?>