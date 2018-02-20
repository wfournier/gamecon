<?php

class func
{

    public static function checkLogin()
    {
        $bool = false;
        if (isset($_COOKIE['account_id']) && isset($_COOKIE['token'])) {
            $account_id = $_COOKIE['account_id'];
            $token = $_COOKIE['token'];

            $query = "SELECT * FROM sessions WHERE session_accountid = " . $account_id . " ;";
            $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);

            if ($results->num_rows > 0) {
                while ($result = $results->fetch_assoc()) {
                    $te = $result['session_token'];
                    if ($result['session_accountid'] == $account_id && $result['session_token'] == $token) {
                        $bool = true;
                    }
                }
            } else {
                print("<script>console.log('no result from query')</script>");
            }
        }
        return $bool;
    }

    public static function login($accountId){
        $token = bin2hex(random_bytes(64/2));
        setcookie("token", $token, (time() + (89400 * 365)), "/");
        setcookie("account_id", $accountId, (time() + (89400 * 365)), "/");
        $set_sess = "INSERT INTO sessions (session_id, session_accountid, session_token) VALUES (NULL, " .
        $accountId . ", '" . $token . "');";
        self::getConnection()->query($set_sess) or die("set session failed " . $con->error);
        header("Location: Account/ModifyInfo.php");
    }

    public static function getConnection()
    {
        $host = "localhost";
        $port = 3306;
        $socket = "";
        $user = "root";
        $password = "root";
        $dbname = "gamecon";

        $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

        return $con;
    }

    public static function getIDFromTicket($token)
    {
        $query = "SELECT TICKET_ID FROM ticket WHERE ID_TOKEN = '" . $token . "' ;";
        $results = self::getConnection()->query($query) or die ("HELP45 " . self::getConnection()->error);
        $string = "";
        if ($results->num_rows > 0) {
            while ($result = $results->fetch_assoc()) {
                $string = $result["TICKET_ID"];
            }
        }
        return $string;
    }

    public static function getFromTable($column, $table, $idFieldName, $id)
    {
        if ($id == null)
            $id = $_COOKIE['account_id'];

        if ($idFieldName == null)
            $idFieldName = "ACCOUNT_ID";

        $table = strtolower($table);
        $column = strtoupper($column);
        $string = "";
        $query = "SELECT " . $column . " FROM " . $table . " WHERE " . $idFieldName . " = " . $id . " ;";
        $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);

        if ($results->num_rows > 0) {
            while ($result = $results->fetch_assoc()) {
                $string = $result["$column"];
            }
        } else {
            print("<script>console.log('no result from query')</script>");
        }

        return $string;
    }

    public static function getIdFromEmail($email){
        $query = "SELECT ACCOUNT_ID FROM ACCOUNT WHERE EMAIL ='" .$email ."';";
        $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);

        if ($results->num_rows > 0) {
            while ($result = $results->fetch_assoc()) {
                $id = $result["ACCOUNT_ID"];
            }
        } else {
            print("<script>console.log('no result from query')</script>");
        }

        return $id;
    }

    public static function setToTable($column, $val, $table, $id, $idFieldName)
    {
        if ($id == null)
            $id = $_COOKIE['account_id'];

        if ($idFieldName == null)
            $idFieldName = "ACCOUNT_ID";

        $table = strtolower($table);
        $column = strtoupper($column);
        $idFieldName = strtoupper($idFieldName);

        $query = "UPDATE " . $table . " SET " . $column . " = '" . $val . "' WHERE " . $idFieldName . " = " . $id . ";";
        $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);
    }

    public static function insertIntoAccount(Account $AccountObj)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/Classes/Account.php";
        $query = "INSERT INTO account (LAST_NAME, FIRST_NAME, EMAIL, PASS_HASH, DATE_OF_BIRTH, PHONE, ADDRESS, CITY, ZIP, COUNTRY_ID, STATE_ID, IS_ADULT) VALUES 
        ('" . $AccountObj->last_name . "', '" . $AccountObj->first_name . "', '" . $AccountObj->email . "', '" . $AccountObj->password .
        "', '" . $AccountObj->dob . "', '" . $AccountObj->phone . "', '" . $AccountObj->address . "', '" . $AccountObj->city . "', '" .
        $AccountObj->zip . "', " . $AccountObj->country . ", " . $AccountObj->state . ", " . $AccountObj->isAdult . ");";
        $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);
    }

    public static function insertIntoTransaction($priceTotal, $token)
    {
        $account_id = $_COOKIE['account_id'];
        $query = "INSERT INTO transaction (TRANSACTION_ID, ACCOUNT_ID, PRICE_TOTAL, ID_TOKEN) VALUES (null, '" . $account_id . "', " . $priceTotal . ", '" . $token . "');";
        $results = self::getConnection()->query($query) or die ("HELP " . self::getConnection()->error);
    }

    public static function insertIntoTicket($token, $price, $extra, $ticket)
    {
        $account_id = $_COOKIE['account_id'];
        $query = "SELECT TRANSACTION_ID FROM transaction WHERE ACCOUNT_ID = " . $account_id . " AND ID_TOKEN = '" . $token . "';";
        $results = self::getConnection()->query($query) or die ("HELP1 " . self::getConnection()->error);
        while ($result = $results->fetch_assoc()) {
            $transac_id = $result['TRANSACTION_ID'];
            if ($transac_id != 0) {
                $query1 = "INSERT INTO ticket (TICKET_ID, TRANSACTION_ID, PRICE, EXTRAS, TICKET_TYPE, ID_TOKEN) VALUES (null, '" . $transac_id . "', " . $price . ", '" . $extra . "', '" . $ticket . "', '" . $token . "');";
                $results1 = self::getConnection()->query($query1) or die ("HELP2 " . self::getConnection()->error);
            }
        }
    }
} ?>