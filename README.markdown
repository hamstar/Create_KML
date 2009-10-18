# Create_KML

A PHP class for creating KML code from a set of data and outputting it to a string.

## Usage

### Initialization

Simply require and initialize the Create_KML class like so:

	require_once 'XML/KML/Create.php';
	$kml = new XML_KML_Create;

### Adding styles to the KML document

To add styles you need to create a new style object, add your style data to it and add it into the KML document.  For multiple styles it would be best to put the following inside a [foreach](http://php.net/foreach).

    // assumes you have $kml setup
	$style = $kml->createStyle();

	$style->setId($style_id)
	    ->setIconId($icon_id)
        ->setIconLink($link);

	$kml->addItem($style);

### Adding placemarks to the KML document

To add a placemark you do the same as for a styles but use a place object.  As such:

    // assumes you have $kml setup
	while ( list($id,$name,$desc,$style_id,$lat,$lng) = mysql_fetch_array($result) ) {

		$place = $kml->createPlace();

		$place->setId($id)
            ->setName($name)
		    ->setDesc($desc)
		    ->setFolder()
		    ->setStyle($style_id)
		    ->setCoords($lat,$lng);

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

Problems, comments, and suggestions all welcome: [hamstar@telescum.co.nz](mailto:hamstar@telescum.co.nz)
