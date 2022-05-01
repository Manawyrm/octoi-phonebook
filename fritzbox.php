<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();

header( "Content-type: application/octet-stream" );
header( "Content-Disposition: attachment; filename=" . "octoi-fritzbox-" . date("Y-m-d") . ".xml" );
header( "Pragma: no-cache" );
header( "Expires: 0" );

function xml_escape($string)
{
	return htmlspecialchars($string, ENT_XML1, 'utf-8');
}
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<phonebooks>
	<phonebook>
		<?php
		$counter = 0;
		foreach ($phonebook as $entry)
		{
			if (!$entry['valid'])
				continue;

			$counter++;
			?>
			<contact>
				<category>0</category>
				<person>
					<realName><?php echo xml_escape($entry['operator']); ?>|<?php echo xml_escape($entry['service']); ?></realName>
				</person>
				<telephony nid="1">
					<number type="home" prio="1" id="0"><?php echo xml_escape($entry['fullnumber']); ?></number>
				</telephony>
				<services />
				<setup />
				<mod_time><?php echo time(); ?></mod_time>
				<uniqueid><?php echo $counter; ?></uniqueid>
			</contact>
			<?php
		}
		?>
	</phonebook>
</phonebooks>