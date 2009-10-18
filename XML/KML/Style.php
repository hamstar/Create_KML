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
* Class to define a style to be added to the KML class
*
* @category XML
* @package  Create_KML
* @author   Robert McLeod <hamstar@telescum.co.nz>
* @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
* @link     ??
*/
class XML_KML_Style extends XML_KML_Common
{
    protected $type = 'style';
    protected $id, $iconid, $iconhref;

    public function getIconId()
    {
        return $this->iconid;
    }

    public function getIconLink()
    {
        return $this->iconhref;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
    * Sets the id, stripping tags
    *
    * @param string $id Id of the style
    *
    * @return void
    */
    public function setId($id)
    {
        $this->id = $this->sanitize($id);
    }
    
    /**
    * Sets the icon id, stripping tags
    *
    * @param string $id Id of the Icon
    *
    * @return void
    */
    public function setIconId($id)
    {
        $this->iconid = $this->sanitize($id);
    }
    
    /**
    * Validates the URL and if its good sets it
    *
    * @param string $href Link to the icon for the style
    *
    * @return void
    * @throws XML_KML_Exception When an invalid URL is provided.
    */
    public function setIconLink($href)
    {
        if (filter_var($href, FILTER_VALIDATE_URL) != false) {
            $this->iconhref = $href;
        }
        
        // Not a valid URL
        throw new XML_KML_Exception("Invalid URL.");
    }
}
?>