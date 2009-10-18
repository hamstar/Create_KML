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

require_once 'XML/KML/Exception.php';

/**
* Class to define a place to be added to the KML class
*
* @category XML
* @package  Create_KML
* @author   Robert McLeod <hamstar@telescum.co.nz>
* @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
* @link     ??
*/
class XML_KML_Place
{
    protected $type = 'place';
    protected $folder = '**[root]**';
    protected $id, $name, $desc, $style, $coords;

    /**
    * Constructor
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
        // Destory all values
        foreach ($this as &$v) {
            $v = null;
        }
    }
    
    /**
    * Encloses a string in CDATA escaping if it
    * contains html tags
    *
    * @param string $data Data to escape
    *
    * @return string
    */
    protected function cdataEscape($data)
    {
        if (strlen($data) != strlen(strip_tags($data))) {
            return "<![CDATA[$data]]>";
        }
        
        return $data;
    }
    
    /**
    * Sets the id, removing any tags from it
    *
    * @param string $id Id of the placemark
    *
    * @access public
    * @return void
    */
    public function setId($id)
    {
        $this->id = strip_tags($id);
        return $this;
    }
    
    /**
    * Sets the name escaping tags with CDATA
    *
    * @param string $name Name of the placemark
    *
    * @access public
    * @return void
    */
    public function setName($name)
    {
        $this->name = $this->cdataEscape($name);
        return $this;
    }
    
    /**
    * Sets the description escaping tags with CDATA
    *
    * @param string $desc Description of the placemark
    *
    * @access public
    * @return $this
    */
    public function setDesc($desc)
    {
        $this->desc = $this->cdataEscape($desc);
        return $this;
    }
    
    /**
    * Sets the style stripping any html and adding
    * a hash sign if not present for the style
    *
    * @param string $style Style of the placemark
    *
    * @access public
    * @return $this
    */
    public function setStyle($style)
    {
        
        $style = strip_tags($style);
        
        // Add a hash for the style
        if (substr($style, 0, 1) != '#') {
            $style = '#' . $style;
        }
        
        $this->style = $style;

        return $this;
    }
    
    /**
    * Sets the coordinates, checking that they are floats
    *
    * @param float $lat Latitude coordinate
    * @param float $lng Longitude coordinate
    *
    * @access public
    * @return $this
    * @throws XML_KML_Exception
    */
    public function setCoords($lat, $lng)
    {
        // Convert to floats if they are in a string
        $lat = floatval($lat);
        $lng = floatval($lng);
        
        // Check that they are floats
        if (is_float($lat) && is_float($lng)) {
            // Set coords
            $this->coords = $lat . ',' . $lng;
            return $this;
        }
        
        // Not a valid set of coordinates
        throw new XML_KML_Exception("Invalid set of coordinates.");
    }
    
    /**
    * Sets the folder name or empty argument sets the folder to root
    *
    * @param string $folder Folder which the placemark goes in
    *
    * @access public
    * @return $this
    */
    public function setFolder($folder = false)
    {
        if ($folder === false) {
            $this->folder = '**[root]**';
        } else {
            $this->folder = $folder;
        }
        return $this;
    }    
}
?>