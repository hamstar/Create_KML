# Create_KML

A PHP class for creating KML code from a set of data and outputting it to a string.

## Usage

### Initialization

Simply require and initialize the Create_KML class like so:

	require_once 'Main.php';
	$kml = new XML_KML_Create;

### Adding styles to the KML document

To add styles you need to create a new style object, add your style data to it and add it into the KML document.  For multiple styles it would be best to put the following inside a [foreach](http://php.net/foreach).

	$sytle = new XML_KML_Style;

	$style->setId($style_id);
	$style->setIconId($icon_id);
	$style->setIconLink($link);

	$kml->addItem($style);

### Adding placemarks to the KML document

To add a placemark you do the same as for a styles but use a place object.  As such:

	while ( list($id,$name,$desc,$style_id,$lat,$lng) = mysql_fetch_array($result) ) {

		$place = new XML_KML_Place;

		$place->setId($id);
		$place->setName($name);
		$place->setDesc($desc);
		$place->setFolder();
		$place->setStyle($style_id);
		$place->setCoords($lat,$lng);

		$kml->addItem($place);

		$place = null;

	}

When the setFolder() method is used with nothing in the brackets, means that the placemark will be put in the root of the KML document.  If you want the placemark in a folder then simply enter the folder name (or variable) into the brackets.

### Outputting the KML code

If you wish to display the code in the browser to a user you can use the printHeader(true) method to show it as an XML document.  If you use the method without an argument it sets the header to the Google Earth KML file type, forcing a download of the KML code.

Here is how to output the code in a browser so it is user-viewable:

	$kml->printHeader(true);
	echo $kml;

Or, maybe you wish to save the code to a file?

	file_put_contents('output.kml', $kml);

Or force the user to download the file:

	$kml->printHeader();
	echo $kml;

## Contact

Problems, comments, and suggestions all welcome at: [hamstar@telescum.co.nz](mailto:hamstar@telescum.co.nz)
