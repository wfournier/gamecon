<?php include $_SERVER['DOCUMENT_ROOT'] . "/Shared/connection.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/Processes/Functions.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/Classes/Ticket.php" ?>
<?php
if (!func::checkLogin()) {
    header("Location: /Login_Register.php");
}
session_start();
if ($_POST["id"] != null) {
    $tickets = $_SESSION["tickets"];
    $id = $_POST["id"];
    $ticket = $tickets["$id"];

    if (isset($_POST["badge"]) && $_POST["badge"] != "") {
        $_SESSION["badge$id"] = $_POST["badge"];
        echo $_POST["badge"];
        $ticket->setBadgeName($_POST["badge"]);
    } else
        $ticket->setBadgeName("");

    //ADD METHOD VALIDATE BADGE NAME WITH DATABASE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    header("Location: /Purchase/SetTickets.php");
} else {
    $_SESSION["Error_Extra"] = "An error occurred while processing extra. Please try again.";
    header("Location: /Purchase/SetTickets.php");
}
?>