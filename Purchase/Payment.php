<?php include $_SERVER['DOCUMENT_ROOT'] . "/Shared/connection.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/Processes/Functions.php" ?>
<?php
if(!func::checkLogin()){
    header("Location: /Login_Register.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment_PayPal</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/Shared/Head.php";?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/Shared/Header.php";?>

<main>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/Shared/Footer.html";?>
</body>
</html>