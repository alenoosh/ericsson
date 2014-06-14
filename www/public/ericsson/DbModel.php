<?php

namespace ericsson\dbmodel;

class DbModel
{
    public function __construct()
    {
    }

    /*
     * connectToDb: tries to connect to the specified database and if the database does not exist,
     *              executes the available sql file to create the database and populate it with data
     */
    public function connectToDb()
    {
        require('dbConfig.php');

        $conn     = \mysqli_connect(ERICSSON_SERVER, ERICSSON_MYSQL_USER, ERICSSON_MYSQL_PASS);
        $dbExists = \mysqli_select_db($conn, ERICSSON_MYSQL_DB);

        if (!$dbExists) {

            $query = \file_get_contents('ericsson_test.sql');
            $result = \mysqli_multi_query($conn, $query);
            while (\mysqli_next_result($conn)) {
                if (!\mysqli_more_results($conn)) {
                    break;
                }
            }

            if ($result) {
                \mysqli_select_db($conn, ERICSSON_MYSQL_DB);
            }
        }

        return $conn;
    }

    /*
     * parseMsisdn: searches for mobile operator information of the given msisdn value
     */
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
