<?php

$badgeName = $emergContact = $emergContactName = "";

$error = $badgeNameErr = $emergContactErr = $emergContactNameErr = false;
$prefOutput = $prefErrMsg = "";

$get_pref_sql = "SELECT PREF_BADGE_NAME, EMERGENCY_CONTACT_PHONE, EMERGENCY_CONTACT_NAME FROM account WHERE ACCOUNT_ID = " . $con->real_escape_string($_COOKIE["account_id"]);
$get_account_info_res = $con->query($get_pref_sql) or die("get_account_info_res: " .$con->error);

while($account = $get_account_info_res->fetch_array()){
	$badgeName = $account["PREF_BADGE_NAME"];
	$emergContact = $account["EMERGENCY_CONTACT_PHONE"];
	$emergContactName = $account["EMERGENCY_CONTACT_NAME"];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$p = $_POST;
	if($p["process"] == "pref"){
		if(!empty($p["badgeName"])){
			if((bool)preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $p["badgeName"]) != true && strpos($p["badgeName"], "/") != true){
				$badgeName = clean($p["badgeName"]);
			} else{
				$badgeNameErr = $error = true;
			}
		}

		if(!empty($p["emergContact"])){
			if((bool)preg_match('/^\(?([0-9]{3})\)?[-.●]?([0-9]{3})[-.●]?([0-9]{4})$/', clean($p["emergContact"]))){
				$emergContact = gut($p["emergContact"]);
			} else{
				$emergContactErr = $error = true;
			}


			if(!empty($p["emergContactName"])){
				if(ctype_alpha(gut($p["emergContactName"]))){
					$emergContactName = $p["emergContactName"];
				} else{
					$emergContactNameErr = $error = true;
				}
			} else{
				$emergContactNameErr = $error = true;
			}
		}

		if($error){
			$prefErrMsg = nl2br($lang("err_msg"));
		} else{
		    $temp1 = str_replace('-', '/', $emergContact);
		    $temp2 = ucwords(strtolower($emergContactName));
			$update_pref_sql = "UPDATE account SET PREF_BADGE_NAME = '" . $con->real_escape_string($badgeName) ."', EMERGENCY_CONTACT_PHONE = '" . $con->real_escape_string($temp1) ."', EMERGENCY_CONTACT_NAME = '" . $con->real_escape_string($temp2) ."' WHERE ACCOUNT_ID = " . $con->real_escape_string($_COOKIE['account_id']);

			if ($con->query($update_pref_sql) === TRUE) {
				$prefOutput = $lang("preferences_saved");
			} else {
				$prefErrMsg = "Error: " . $update_pref_sql . "<br>" . $con->error;
			}
		}
	}
}

?>