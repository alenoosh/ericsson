<?php

namespace ericsson\test;

use ericsson\dbmodel as dbmodel;

class NumberLookup
{
    public function __construct()
    {
    }

    public function parseMsisdn($msisdn)
    {
        require_once('DbModel.php');

        $database = new dbmodel\DbModel();
        $result   = $database->parseMsisdn($msisdn);

        return $result;
    }

    public function msisdnLookup($method, $params)
    {
        $msisdn = $params[0]["msisdn"];
        $result = "";

        if ($msisdn) {
            $info   = $this->parseMsisdn($msisdn);
            $result = $info[0]["operator_name"] . ", " . $info[0]["country_dial_code"] . ", " .
                      substr($msisdn, strlen($info[0]["country_dial_code"])) . ", " . $info[0]["country_code"];
        }

        return $result;
    }
}
