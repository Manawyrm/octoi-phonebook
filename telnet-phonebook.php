<?php
require_once("phonebook.php");

// We want to have the last-change date and user, so let's fetch manually here.
$html = file_get_contents($phonebookURL);
$phonebook = parse_phonebook($html);

header( "Content-type: text/plain" );
header( "Pragma: no-cache" );
header( "Expires: 0" );

echo "Welcome to the Osmocom Community TDM over IP phonebook!\r\n";

// Parse/print last change date
$matches = [];
$re = '/Updated by <a class="user active" href=".*">(.*?)<\/a> <a title="(.*?)" href="\/projects\/octoi\/activity\?from=.*">(.*)<\/a> ago/m';
preg_match_all($re, $html, $matches, PREG_SET_ORDER, 0);
if (count($matches) == 1 && count($matches[0]) == 4)
{
    echo "The phonebook was last edited by " . $matches[0][1] . " " . $matches[0][3] . " ago.\r\n";
}

echo "\r\n";
echo "The following extensions are listed:\r\n";

foreach ($phonebook as $entry)
{
    if (!$entry['valid'])
        continue;

    echo $entry['area'] . " " . $entry['prefix'] . " " . $entry['extension'] . " - " . $entry['operator'] . " - ". $entry['service'] . "\r\n";
    echo "    " . str_replace(". ", "\r\n    ", $entry['description']) . "\r\n\r\n" ;

}
