<?php
namespace Sabre\DAVACL\PrincipalBackend;

use Sabre\DAV;
use Sabre\DAV\MkCol;
use Sabre\HTTP\URLUtil;

class DummyPrincipalBackend extends AbstractBackend implements CreatePrincipalSupport {
    function getPrincipalsByPrefix($prefixPath) {
        return [
                [
                "id" => 1,
                "uri" => "principals/octoi",
                "{DAV:}displayname" => "OCTOI",
                "{http://sabredav.org/ns}email-address" => "octoi@retronetworking.org"
            ]
        ];
    }

    function getPrincipalByPath($path) {
        return [
            "id" => 1,
            "uri" => "principals/octoi",
            "{DAV:}displayname" => "OCTOI",
            "{http://sabredav.org/ns}email-address" => "octoi@retronetworking.org"
        ];
    }

    function updatePrincipal($path, DAV\PropPatch $propPatch) {

    }

    function searchPrincipals($prefixPath, array $searchProperties, $test = 'allof') {
        return [];
    }

    function findByUri($uri, $principalPrefix) {
        return "/principals/octoi";
    }

    function getGroupMemberSet($principal) {
        return [];
    }

    function getGroupMembership($principal) {
        return [];
    }

    function setGroupMemberSet($principal, array $members) {
        
    }

    function createPrincipal($path, MkCol $mkCol) {

    }
}
