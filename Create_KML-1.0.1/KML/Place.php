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
    /**
    * Constructor
    *
    */
    function __construct()
    {
        protected $type = 'place';
        protected $folder = '**[root]**';
        protected $id, $name, $desc, $style, $coords;
    }
    
    /**
    * Destructor
    *
    */
    function __destruct()
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
    * @access private
    * @return string
    */
    private function _cdataEscape($data)
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
        $this->name = $this->_cdataEscape($name);
    }
    
    /**
    * Sets the description escaping tags with CDATA
    *
    * @param string $desc Description of the placemark
    *
    * @access public
    * @return void
    */
    public function setDesc($desc)
    {
        $this->desc = $this->_cdataEscape($desc);
    }
    
    /**
    * Sets the style stripping any html and adding
    * a hash sign if not present for the style
    *
    * @param string $style Style of the placemark
    *
    * @access public
    * @return void
    */
    public function setStyle($style)
    {
        
        $style = strip_tags($style);
        
        // Add a hash for the style
        if (substr($style, 0, 1) != '#') {
            $style = '#' . $style;
        }
        
        $this->style = $style;
    }
    
    /**
    * Sets the coordinates, checking that they are floats
    *
    * @param float $lat Latitude coordinate
    * @param float $lng Longitude coordinate
    *
    * @access public
    * @return bool
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
            return true;
        }
        
        // Not a valid set of coordinates
        return false;
    }
    
    /**
    * Sets the folder name or empty argument sets the folder to root
    *
    * @param string $folder Folder which the placemark goes in
    *
    * @access public
    * @return void
    */
    public function setFolder($folder = false)
    {
        if ($folder === false) {
            $this->folder = '**[root]**';
        } else {
            $this->folder = $folder;
        }
    }
    
    
}
?>