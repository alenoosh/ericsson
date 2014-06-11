<?php

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
