<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();

$csv = "";

$csv .= str_putcsv([
	"BEZCHNG",
	"FIRMA",
	"NAME",
	"VORNAME",
	"ABTEILUNG",
	"STRASSE",
	"PLZ",
	"ORT",
	"KOMMENT",
	"TELEFON",
	"TELEFAX",
	"TRANSFER",
	"TERMINAL",
	"BENUTZER",
	"PASSWORT",
	"TRANSPROT",
	"TERMMODE",
	"NOTIZEN",
	"MOBILFON",
	"EMAIL",
	"HOMEPAGE"
], "\t", "\"", "\\") . "\r\n";

$known = [];
foreach ($phonebook as $entry)
{
	if (!$entry['valid'])
		continue;

	// Fritz!Addr doesn't like entries with the same name.
	// Let's concat " - 2", " - 3", etc.:
	$bezeichnung = $entry['operator'] . " - ". $entry['service'];
	$counter = 1;
	while (in_array($bezeichnung, $known))
	{
		$counter++;
		$bezeichnung = $entry['operator'] . " - ". $entry['service'] . " - " . $counter;
	}
	$known[] = $bezeichnung;
	
	$csv .= str_putcsv([
		utf8_decode($bezeichnung), // BEZCHNG
		"", // FIRMA
		utf8_decode($entry['operator']), // NAME
		"", // VORNAME
		"", // ABTEILUNG
		"", // STRASSE
		"", // PLZ
		"", // ORT
		utf8_decode($entry['description']), // KOMMENT
		utf8_decode($entry['fullnumber']), // TELEFON
		utf8_decode($entry['fullnumber']), // TELEFAX
		"", // TRANSFER
		"", // TERMINAL
		"", // BENUTZER
		"", // PASSWORT
		"", // TRANSPROT
		"", // TERMMODE
		"", // NOTIZEN
		"", // MOBILFON
		"", // EMAIL
		""  // HOMEPAGE
	], "\t", "\"", "\\") . "\r\n";
}

header( "Content-type: application/octet-stream" );
header( "Content-Disposition: attachment; filename=" . "octoi-fritzaddr-" . date("Y-m-d") . ".txt" );
header( "Content-length: " . strlen($csv) );
header( "Pragma: no-cache" );
header( "Expires: 0" );

echo $csv;