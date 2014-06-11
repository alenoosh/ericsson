<?php

namespace ericsson\dbmodel;

class DbModel
{
    public function __construct()
    {
    }

    public function connectToDb()
    {
        $server   = 'localhost';
        $user     = 'root';
        $pass     = 'root';
        $database = 'ericsson_test';

        // Check whether the database exists
        $conn     = \mysqli_connect($server, $user, $pass);
        $dbExists = \mysqli_select_db($conn, $database);

        if (!$dbExists) {
            $sqlFile = 'ericsson_test.sql';

            $command = 'mysql -h' . $server . ' -u' . $user . ' -p' . $pass . ' < ' . $sqlFile;
            exec($command, $output = array(), $worked);
            if ($worked == 0) {
                $conn = \mysqli_connect($server, $user, $pass, $database);
            }
        }

        return $conn;
    }

    public function parseMsisdn($msisdn)
    {
        $database = $this->connectToDb();

        $query = "select * from ericsson_mobile_operators where first_digits = SUBSTRING('" .
                 $msisdn . "', 1, CHAR_LENGTH(`first_digits`)) AND country_dial_code != ''";
        $result = \mysqli_query($database, $query);

        $mobileInfo = array();
        if (!empty($result)) {
            while ($info = \mysqli_fetch_array($result, MYSQL_ASSOC)) {
                $mobileInfo[] = $info;
            }
        }

        return $mobileInfo;
    }
}
