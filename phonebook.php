<?php

// evil hack, but we need windows line endings for many formats
if (!function_exists('str_putcsv')) {
    function str_putcsv($input, $delimiter, $enclosure, $escape) 
    {
        $fp = fopen('php://temp', 'r+b');
        fputcsv($fp, $input, $delimiter, $enclosure, $escape);
        rewind($fp);
        $data = rtrim(stream_get_contents($fp), "\n");
        fclose($fp);
        return $data;
    }
}

$phonebookURL = 'https://osmocom.org/projects/octoi/wiki/Phonebook';

function fetch_phonebook()
{
	global $phonebookURL;
	$html = file_get_contents($phonebookURL);
	return parse_phonebook($html);
}

function parse_phonebook($html)
{
	$dom = new domDocument;

	@$dom->loadHTML($html);
	$dom->preserveWhiteSpace = false;

	$tables = $dom->getElementsByTagName('table');

	$rows = $tables->item(0)->getElementsByTagName('tr');
	$entries = [];

	foreach ($rows as $row)
	{
		$th_cols = $row->getElementsByTagName('th');
		if ($th_cols->length > 0)
		{
			// Header row
			$header = parse_tabledata_elements($th_cols);
			// sanity check: Let's check if the header is still the same so we don't parse garbage data
			if ($header[0] == "" && 
				$header[1] == "Prefix" && 
				$header[2] == "Extension" &&
				$header[3] == "Operator" && 
				$header[4] == "Service" &&
				$header[5] == "Description"	)
			{
				// header ok	
			}
			else
			{
				throw new Exception("Phonebook table header has changed / is in an unexpected format. Aborting.");
			}
		}

		$td_cols = $row->getElementsByTagName('td');
		if ($td_cols->length > 0)
		{
			// Entry row
			$data = parse_tabledata_elements($td_cols);
			$newEntry = [
				"area" => trim($data[0] ?? ''),
				"prefix" => trim($data[1] ?? ''),
				"extension" => trim($data[2] ?? ''),
				"operator" => trim($data[3] ?? ''),
				"service" => trim($data[4] ?? ''),
				"description" => trim($data[5] ?? '')
			];

			$prefix = "";
			if (isset($_GET['prefix']))
			{
				if (is_numeric($_GET['prefix']))
				{
					$prefix = $_GET['prefix'];
				}
			}
			$newEntry['fullnumber'] = $prefix . $newEntry['area'] . $newEntry['prefix'] . $newEntry['extension'];

			// Basic validity checks (only digits, etc.)
			$valid = true;

			if (!is_numeric($newEntry['area']))
				$valid = false;

			if (!is_numeric($newEntry['prefix']))
				$valid = false;

			if (!is_numeric($newEntry['extension']))
				$valid = false;

			$newEntry['valid'] = $valid;

			// Try to guess the service type
			$newEntry['guessedType'] = classify_service_type($newEntry);

			$entries[] = $newEntry;
		}
	}

	return $entries;
}



function classify_service_type($entry)
{
	$keywords = [
		"data" => ["dialup", "v.90", "x.75", "v.120", "bbs", "btx", "ppp", "portmaster", "isdn-ta", "terminal adapter"],
		"fax" => ["g3", "g4", "fax"],
		"phone" => ["analog phone", "isdn phone", "audio", "cet", "cest", "voip", "voice", "dect", "chiptune", "music", "time announcement"],
		"video" => ["t-view", "video phone", "h.320", "videotelephony"]
	];

	$found = [];

	foreach ($keywords as $serviceclass => $servicekeywords)
	{
		foreach ($servicekeywords as $servicekeyword)
		{
			if (strpos(strtolower($entry['service']), $servicekeyword) !== false || 
				strpos(strtolower($entry['description']), $servicekeyword) !== false)
			{
				if (!isset($found[$serviceclass]))
					$found[$serviceclass] = 0;

				$found[$serviceclass]++;
			}

		}
	}

	arsort($found, SORT_NUMERIC);
	if (count($found) > 0)
	{
		return array_key_first($found);
	}

	return "unknown";
}

function parse_tabledata_elements(object $tds)
{
	$return = [];
	foreach ($tds as $td)
	{
		$return[] = $td->nodeValue;
	}

	return $return;
}