<?php

namespace Sabre\CardDAV\Backend;

use Sabre\CardDAV;
use Sabre\DAV;

class CardDAVBackend extends AbstractBackend implements SyncSupport
{
    function getAddressBooksForUser($principalUri) {
        $addressBooks = [];
        $addressBooks[] = [
            'id'                                                          => 1,
            'uri'                                                         => "octoi",
            'principaluri'                                                => "principals/octoi",
            '{DAV:}displayname'                                           => "OCTOI Phonebook",
            '{' . CardDAV\Plugin::NS_CARDDAV . '}addressbook-description' => null,
            '{http://calendarserver.org/ns/}getctag'                      => null,
            '{http://sabredav.org/ns}sync-token'                          => null,
        ];
        return $addressBooks;
    }

    function updateAddressBook($addressBookId, \Sabre\DAV\PropPatch $propPatch)
    {
       return;
    }

    function createAddressBook($principalUri, $url, array $properties)
    {
        return;
    }

    function deleteAddressBook($addressBookId)
    {
        return;
    }

    function getCards($addressbookId)
    {
        global $phonebook;

        $return = [];
        foreach ($phonebook as $entry)
        {
            if (!$entry['valid'])
                continue;

            $counter = 0;

            $return[] = [
                "id" => $counter++,
                "uri" => $entry['fullnumber'] . ".vcf", 
                "lastmodified" => time(),
            ];
        }
        return $return;
    }

    function getCard($addressBookId, $cardUri)
    {
        global $phonebook;

        foreach ($phonebook as $entry)
        {
            if ($entry['valid'] && ($entry['fullnumber'] . ".vcf") == $cardUri)
            {
                $vcard = new \Sabre\VObject\Component\VCard([
                    'UID' => "octoi-" . $entry['fullnumber'],
                    'FN'  => $entry['service'] . " - " . $entry['operator'],
                    'TEL' => $entry['fullnumber'],
                    'N'   => [$entry['service'], $entry['operator'], '', '', ''],
                    'NOTE' => $entry['description']
                ]);

                return [
                    "carddata" => $vcard->serialize(), 
                    "uri" => $cardUri, 
                    "lastmodified" => time()
                ];
            }
        }
        return false;
       
    }

    function getMultipleCards($addressBookId, array $uris) {
        $return = [];
        foreach ($uris as $uri)
        {
            $return[] = $this->getCard($addressBookId, $uri);
        }
        return $return;
    }

    function createCard($addressBookId, $cardUri, $cardData) {
        return null;
    }

    function updateCard($addressBookId, $cardUri, $cardData) {
        return null;
    }

    function deleteCard($addressBookId, $cardUri) {
        return false;
    }

    function getChangesForAddressBook($addressBookId, $syncToken, $syncLevel, $limit = null) {
        return null;
    }

    protected function addChange($addressBookId, $objectUri, $operation) {
        return;
    }
}
