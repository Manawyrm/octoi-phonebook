<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();

$csv = "";

$seperator = ",";
if (isset($_GET['lang']) && $_GET['lang'] == "de")
{
	$seperator = ";";
	$csv .= str_putcsv([
		utf8_decode("Name"),
		utf8_decode("E-Mail-Adresse"),
		utf8_decode("Straße (privat)"),
		utf8_decode("Ort (privat)"),
		utf8_decode("Postleitzahl (privat)"),
		utf8_decode("Bundesland (privat)"),
		utf8_decode("Land/Region (privat)"),
		utf8_decode("Rufnummer (privat)"),
		utf8_decode("Straße (geschäftlich)"),
		utf8_decode("Ort (geschäftlich)"),
		utf8_decode("Postleitzahl (geschäftlich)"),
		utf8_decode("Bundesland (geschäftlich)"),
		utf8_decode("Land/Region (geschäftlich)"),
		utf8_decode("Rufnummer (geschäftlich)"),
		utf8_decode("Firma"),
		utf8_decode("Position"),
		utf8_decode("Kommentare"),
	], $seperator, "\"", "\\") . "\r\n";
}
else
{
	$csv .= str_putcsv([
		utf8_decode("Name"),
		utf8_decode("E-mail Address"),
		utf8_decode("Home Street"),
		utf8_decode("Home City"),
		utf8_decode("Home Postal Code"),
		utf8_decode("Home State"),
		utf8_decode("Home Country/Region"),
		utf8_decode("Home Phone"),
		utf8_decode("Business Street"),
		utf8_decode("Business City"),
		utf8_decode("Business Postal Code"),
		utf8_decode("Business State"),
		utf8_decode("Business Country/Region"),
		utf8_decode("Business Phone"),
		utf8_decode("Company"),
		utf8_decode("Job Title"),
		utf8_decode("Notes"),
	], $seperator, "\"", "\\") . "\r\n";
}

$known = [];
foreach ($phonebook as $entry)
{
	if (!$entry['valid'])
		continue;

	// Windows addressbook doesn't like entries with the same name.
	// Let's concat " - 2", " - 3", etc.:
	$name = $entry['operator'] . " - ". $entry['service'];
	$counter = 1;
	while (in_array($name, $known))
	{
		$counter++;
		$name = $entry['operator'] . " - ". $entry['service'] . " - " . $counter;
	}
	$known[] = $name;

	$csv .= str_putcsv([
		utf8_decode($name), // Name
		"", // E-Mail-Adresse
		"", // Straße (privat)
		"", // Ort (privat)
		"", // Postleitzahl (privat)
		"", // Bundesland (privat)
		"", // Land/Region (privat)
		utf8_decode($entry['fullnumber']), // Rufnummer (privat)
		"", // Straße (geschäftlich)
		"", // Ort (geschäftlich)
		"", // Postleitzahl (geschäftlich)
		"", // Bundesland (geschäftlich)
		"", // Land/Region (geschäftlich)
		"", // Rufnummer (geschäftlich)
		"", // Firma
		"", // Position
		utf8_decode($entry['description']), // Kommentare
	], $seperator, "\"", "\\") . "\r\n";
}

header( "Content-type: application/octet-stream" );
header( "Content-Disposition: attachment; filename=" . "octoi-windows-addressbook-" . date("Y-m-d") . ".csv" );
header( "Content-length: " . strlen($csv) );
header( "Pragma: no-cache" );
header( "Expires: 0" );

echo $csv;