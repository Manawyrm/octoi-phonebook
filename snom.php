<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();

header( "Content-type: text/xml" );
//header( "Content-Disposition: attachment; filename=" . "octoi-fritzaddr-" . date("Y-m-d") . ".txt" );
//header( "Content-length: " . strlen($csv) );
header( "Pragma: no-cache" );
header( "Expires: 0" );

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<SnomIPPhoneDirectory>
    <Title>OCTOI</Title>
<?php
foreach ($phonebook as $entry)
{
    if (!$entry['valid'])
        continue;

    ?>
    <DirectoryEntry>
        <Name><?php echo htmlspecialchars($entry['operator'] . " - ". $entry['service']); ?></Name>
        <Telephone><?php echo htmlspecialchars($entry['fullnumber']); ?></Telephone>
    </DirectoryEntry>
    <?php
}
?>
</SnomIPPhoneDirectory>