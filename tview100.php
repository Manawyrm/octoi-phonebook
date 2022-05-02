<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();

function enter_char(string $char)
{
	$chars = [
		" " => ["0"],
		"." => ["0", "0"],
		"-" => ["0", "0", "0"],
		"0" => ["0", "0", "0"],

		"ä" => ["1"],
		"ö" => ["1", "1"],
		"ü" => ["1", "1", "1"],
		"ß" => ["1", "1", "1"],
		"1" => ["1", "1", "1"],

		"A" => ["2"],
		"B" => ["2", "2"],
		"C" => ["2", "2", "2"],
		"2" => ["2", "2", "2", "2"],

		"D" => ["3"],
		"E" => ["3", "3"],
		"F" => ["3", "3", "3"],
		"3" => ["3", "3", "3", "3"],

		"G" => ["4"],
		"H" => ["4", "4"],
		"I" => ["4", "4", "4"],
		"4" => ["4", "4", "4", "4"],

		"J" => ["5"],
		"K" => ["5", "5"],
		"L" => ["5", "5", "5"],
		"5" => ["5", "5", "5", "5"],

		"M" => ["6"],
		"N" => ["6", "6"],
		"O" => ["6", "6", "6"],
		"6" => ["6", "6", "6", "6"],

		"P" => ["7"],
		"Q" => ["7", "7"],
		"R" => ["7", "7", "7"],
		"S" => ["7", "7", "7", "7"],
		"7" => ["7", "7", "7", "7", "7"],

		"T" => ["8"],
		"U" => ["8", "8"],
		"V" => ["8", "8", "8"],
		"8" => ["8", "8", "8", "8"],

		"W" => ["9"],
		"X" => ["9", "9"],
		"Y" => ["9", "9", "9"],
		"Z" => ["9", "9", "9", "9"],
		"9" => ["9", "9", "9", "9", "9"],

		"#" => ["#"],

		"*" => ["*"],
		"/" => ["*", "*"],
		"(" => ["*", "*", "*"],
		")" => ["*", "*", "*", "*"],
		"<" => ["*", "*", "*", "*", "*"],
		"=" => ["*", "*", "*", "*", "*", "*"],
		">" => ["*", "*", "*", "*", "*", "*", "*"],
		"&" => ["*", "*", "*", "*", "*", "*", "*", "*"],
		"@" => ["*", "*", "*", "*", "*", "*", "*", "*", "*"],
	];

	foreach ($chars[$char] as $keypress)
	{
		press_key($keypress, 0);
	}
	press_key(">", 0);
}

function press_key(string $keyname, int $sleep = 100)
{
	$keys = [
		"OnHook" =>         ['bTranslate' => '0', 'wKeyEvent' => '00 0b'],
		"OffHook" =>        ['bTranslate' => '0', 'wKeyEvent' => '00 0b'],
		"1" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 0e'],
		"2" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 0f'],
		"3" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 10 10'],
		"4" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 11'],
		"5" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 12'],
		"6" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 13'],
		"7" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 14'],
		"8" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 15'],
		"9" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 16'],
		"0" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 0d'],
		"*" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 17'],
		"#" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 10 18'],
		"<" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 1a'],
		">" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 1b'],
		"OK" =>             ['bTranslate' => '0', 'wKeyEvent' => '00 19'],
		"STOP" =>           ['bTranslate' => '0', 'wKeyEvent' => '00 28'],
		"+" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 23'],
		"-" =>              ['bTranslate' => '0', 'wKeyEvent' => '00 22'],
		"Telefonbuch" =>    ['bTranslate' => '1', 'wKeyEvent' => '00 22'],
		"Wahlwdh" =>        ['bTranslate' => '1', 'wKeyEvent' => '00 24'],
		"F1" =>             ['bTranslate' => '1', 'wKeyEvent' => '00 1b'],
		"F2" =>             ['bTranslate' => '1', 'wKeyEvent' => '00 23'],
		"F3" =>             ['bTranslate' => '1', 'wKeyEvent' => '00 36'],
		"F4" =>             ['bTranslate' => '1', 'wKeyEvent' => '00 2f'],
		"Stumm" =>          ['bTranslate' => '1', 'wKeyEvent' => '00 1a'],
		"Lautsprecher" =>   ['bTranslate' => '1', 'wKeyEvent' => '00 12'],
		"Bild ein" =>       ['bTranslate' => '1', 'wKeyEvent' => '00 35'],
		"Bild in Bild" =>   ['bTranslate' => '1', 'wKeyEvent' => '00 2d'],
		"Standbild" =>      ['bTranslate' => '1', 'wKeyEvent' => '00 34'],
		"AB abfragen" =>    ['bTranslate' => '1', 'wKeyEvent' => '00 32'],
		"AB ein" =>         ['bTranslate' => '1', 'wKeyEvent' => '00 2a'],
	];
	echo "\n";
	echo "echo -n " . escapeshellarg( $keyname . " ") . " >&2 \n";
	echo 'echo "02 00 00 05 00 F8 07 0C 63 00 09 00 5B 00 01 00 00 0' . $keys[$keyname]['bTranslate'] . ' ' . $keys[$keyname]['wKeyEvent'] . ' FF 00 03" | xxd -r -p > $PORT' . "\n";

	if ($sleep)
	{
		echo_sleep($sleep);
	}
}

function log_output(string $log)
{
	echo "\necho \necho " . escapeshellarg($log) . " >&2\n";
}

function echo_sleep(int $duration_ms)
{
	echo "/usr/bin/sleep " . $duration_ms / 1000 . " \n";
}

header( "Content-type: text/plain" );
header( "Content-Disposition: attachment; filename=" . "octoi-tview100-" . date("Y-m-d") . ".sh" );
//header( "Content-length: " . strlen($csv) );
header( "Pragma: no-cache" );
header( "Expires: 0" );

?>#!/bin/bash
# This is a bash script, which will replace the T-View 100's phonebook via
# an RS232 cable. All these commands are emulating keypresses. 
# The existing phonebook will be deleted, then all new entries will be created.
# 
# ./octoi-tview100-<?php echo date("Y-m-d"); ?>.sh /dev/ttyUSB0

PORT=$1
stty -F $PORT 19200 cstopb cs8 crtscts

<?php

log_output("Bringing phone into sane state");
press_key("OnHook", 2000);
press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);

log_output("Wiping phonebook");
press_key(">", 50);
press_key(">", 50);
press_key(">", 50);
press_key(">", 50);
press_key("OK", 100);
press_key("3", 100); // Lokale Funktionen
press_key("4", 100); // hidden Menu: "Speicher löschen"
press_key("5", 100); // Telefonbuch löschen
press_key(">", 100);
press_key("OK", 15000); // Wiping phonebook takes forever
press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);

$known = [];
foreach ($phonebook as $entry)
{
	if (!$entry['valid'])
		continue;

	if ($entry['guessedType'] != "phone" && $entry['guessedType'] != "video")
		continue;

	if (strlen($entry['fullnumber']) > 18)
	{
		log_output("Phonenumber " . $entry['fullnumber'] . " is too long for phonebook. Skipping!");
		continue;
	}

	if (in_array($entry['fullnumber'], $known))
	{
		log_output("Phonenumber " . $entry['fullnumber'] . " exists twice. Skipping!");
		continue;
	}
	$known[] = $entry['fullnumber'];

	log_output("Creating entry: " . $entry['operator'] . " - ". $entry['service']);

	// Create entries
	press_key("STOP", 100);
	press_key("STOP", 100);
	press_key("STOP", 100);
	press_key("Telefonbuch", 100);
	press_key("2", 100); // Neueintrag

	foreach (str_split($entry['fullnumber']) as $digit)
	{
		press_key($digit, 100);
	}

	// If this is a video number, set the video flag
	if ($entry['guessedType'] == "video")
	{
		press_key("Bild ein", 100);
	}

	press_key("OK", 100);

	$name = $entry['service'];
	$name = mb_ereg_replace("/[a-zA-Z0-9äöüß\-\.\#\*\/\(\)\<\=\>\&\@_]+/u", '', $name);
	$name = strtoupper($name);
	$name = substr($name, 0, 18);

	log_output("T-View safe name: " . $name);

	foreach (str_split($name) as $letter)
	{
		enter_char($letter);
	}

	press_key("OK", 2000); // Creating entry takes a while
}

press_key("STOP", 200);
press_key("STOP", 200);
press_key("STOP", 200);

log_output("Finished uploading phonebook!");
