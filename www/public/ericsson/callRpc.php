<?php

/* This is a sample RPC Client Script :
 * It uses an msisdn value and sends a request to RPC Server Script (rpcIndex.php)
 * to return the mobile operator information of the given msisdn
 */

try {
    $requestArr = array('msisdn' => '38640123456');
    $request    = xmlrpc_encode_request('msisdnLookup', array($requestArr), array('encoding' => 'UTF-8'));

    $context = stream_context_create(
        array(
            'http' => array(
                'method' => "POST",
                'header' => "Content-Type: text/xml",
                'content' => $request
                )
             )
    );

    $file = file_get_contents('http://localhost/ericsson/rpcIndex.php', false, $context);

    if (!$file) {
        throw new Exception('Unable to get response from web service');
    }

    $response = xmlrpc_decode($file);

    echo $response;

} catch (Exception $e) {
    echo $e->getMessage();
}
