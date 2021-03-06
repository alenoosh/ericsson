<?php

    /*
     * This is the RPC Server Script: It gets the request with an msisdn parameter and
     * calls msisdnLookup method to return the mobile operator information of msisdn value
     */

    require_once("NumberLookup.php");

    $lookup = new ericsson\test\NumberLookup();

    $server = xmlrpc_server_create();

    xmlrpc_server_register_method($server, 'msisdnLookup', array($lookup, 'msisdnLookup'));

    $request  = file_get_contents('php://input');
    $response = xmlrpc_server_call_method($server, $request, null);

    header('Content-Type: text/xml');

    echo $response;
