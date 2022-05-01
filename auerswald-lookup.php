<?php
require_once("phonebook.php");
header( "Content-type: text/plain" );

$phonebook = fetch_phonebook();

if (isset($_REQUEST['phone']) && is_numeric($_REQUEST['phone']))
{
	$phone = trim($_REQUEST['phone']);
	
	// Local prefix is an optional parameter which allows local calls to be recognised
	// Example: If your prefix is 0306502, and your Auerswald requests 04011 or 4011,
	// this script will lookup 03065024011 instead and return the appropriate entries.
	$localprefix = "";
	if (isset($_REQUEST['localprefix']) && is_numeric($_REQUEST['localprefix']))
	{
		$localprefix = $_REQUEST['localprefix'];
		if (strlen($phone) == 4)
		{
			$phone = $localprefix . $phone;
		}
		if (strlen($phone) == 5)
		{
			$phone = $localprefix . substr($phone, 1);
		}
	}


	foreach ($phonebook as $entry)
	{
		if ($entry['fullnumber'] == $phone || $entry['fullnumber'] == substr($phone, 1))
		{
			echo "success: \"" . htmlspecialchars($entry['operator']) . " - " . htmlspecialchars($entry['service']) . "\"\r\n";
			return;
		}
	}

	http_response_code(404);
	return;
}

echo "no phone number provided!";

