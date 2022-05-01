<?php
namespace Sabre\DAV\Auth\Backend;

use Sabre\HTTP\RequestInterface;
use Sabre\HTTP\ResponseInterface;

class NoneAuth implements BackendInterface
{
    protected $principalPrefix = 'principals/';

    function check(RequestInterface $request, ResponseInterface $response) {
        $remoteUser = "octoi";
        return [true, $this->principalPrefix . $remoteUser];
    }

    function challenge(RequestInterface $request, ResponseInterface $response) {

    }

}
