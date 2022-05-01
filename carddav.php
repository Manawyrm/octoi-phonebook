<?php
date_default_timezone_set('Europe/Berlin');

$baseUri = '/carddav.php/';
require_once 'phonebook.php';

global $phonebook;
$phonebook = fetch_phonebook();

function exception_error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

// Autoloader
require_once 'carddav/vendor/autoload.php';
require_once 'carddav/NoneAuth.php';
require_once 'carddav/CardDAVBackend.php';
require_once 'carddav/DummyPrincipalBackend.php';

// Backends
$authBackend = new Sabre\DAV\Auth\Backend\NoneAuth();
$principalBackend = new Sabre\DAVACL\PrincipalBackend\DummyPrincipalBackend();
$carddavBackend = new Sabre\CardDAV\Backend\CardDAVBackend();

$nodes = [
    new Sabre\DAVACL\PrincipalCollection($principalBackend),
    new Sabre\CardDAV\AddressBookRoot($principalBackend, $carddavBackend),
];

$server = new Sabre\DAV\Server($nodes);
$server->setBaseUri($baseUri);

$server->addPlugin(new Sabre\DAV\Auth\Plugin($authBackend));
$server->addPlugin(new Sabre\DAV\Browser\Plugin());
$server->addPlugin(new Sabre\CardDAV\Plugin());
$server->addPlugin(new Sabre\DAVACL\Plugin());
$server->addPlugin(new Sabre\DAV\Sync\Plugin());

$server->exec();