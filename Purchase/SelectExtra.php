<?php include $_SERVER['DOCUMENT_ROOT'] . "/clicon" . "/Shared/connection.php" ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/clicon" . "/Processes/Functions.php" ?>
<?php

if (!func::checkLogin()) {
    header("Location: /clicon/Login_Register.php");
}
session_start();

if ($_GET["id"] == null) {
    $_SESSION["Error_Edit"] = "An error occurred while processing extra. Please try again.";
    header("Location: /clicon/Purchase/SetTickets.php");
} else
    $id = $_GET["id"];
    if (!isset($_SESSION["concert$id"]))
        $_SESSION["concert$id"] = null;
if (!isset($_SESSION["panel$id"]))
    $_SESSION["panel$id"] = null;
if (!isset($_SESSION["guest$id"]))
    $_SESSION["guest$id"] = null;
$_SESSION["Error_Ticket$id"] = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment_ExtraSelection</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/clicon" . "/Shared/Head.php"; ?>
    <script src="/clicon/Scripts/PriceScriptExtra.js"></script>
    <style>
        label {
            width: 100px;
            margin-left: 30px;
        }
    </style>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/clicon" . "/Shared/Header.php"; ?>
<main>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="post" action="ProcessingSelectExtra.php">
                <div class="row" style="min-height: 500px">
                    <div class="breadcrumbs"><a href="/clicon/Purchase/SetTickets.php"><?php echo($lang("bread_set_ticket")); ?> </a>></div>
                    <div class="lowerbreadcrumbs"><a href="/clicon/Purchase/SelectTicket.php?id=<?php echo $id?>"><?php echo($lang("bread_select_ticket")); ?> </a>>
                        <a href="/clicon/Purchase/SelectExtra.php?id=<?php echo $id?>"><?php echo($lang("bread_select_extra")); ?> </a>></div>
                    <h1 style="margin-top: 0"><?php echo($lang("select_extras")); ?>:</h1>
                    <table id="priceChart" align="center" style="color: white; margin: 0 0 20px 0;">
                        <tr>
                            <th>1 extras</th>
                            <th>2 extras</th>
                            <th>3 extras</th>
                            <th>4 extras</th>
                            <th>5+ extras</th>
                        </tr>
                        <tr>
                            <td><?php echo($lang("currency", "10")); ?></td>
                            <td><?php echo($lang("currency", "17")); ?></td>
                            <td><?php echo($lang("currency", "23")); ?></td>
                            <td><?php echo($lang("currency", "27")); ?></td>
                            <td><?php echo($lang("currency", "30")); ?></td>
                        </tr>
                    </table>

                    <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
                    <label for="concert"><?php echo($lang("ticket_extra_concert")); ?>: </label><input id="concert" type="checkbox" name="concert"
                        <?php
                        $id = $_GET["id"];
                        if ($_SESSION["concert$id"] == "something") {
                            echo "checked";
                        } ?>
                    ><br><br>
                    <label for="panel"><?php echo($lang("ticket_extra_panel")); ?>: </label><input id="panel" type="checkbox" name="panel"
                        <?php if ($_SESSION["panel$id"] == "something") {
                            echo "checked";
                        } ?>
                    ><br><br>
                    <label for="guest"><?php echo($lang("ticket_extra_vip")); ?>: </label><input id="guest" type="checkbox" name="guest"
                        <?php if ($_SESSION["guest$id"] == "something") {
                            echo "checked";
                        } ?>
                    >
                    <br><br>
                    <p class="priceUTD">Ticket #<?php echo $id; ?>: $
                        <span id="price2">0</span>
                    </p>
                </div>
                <div class="row"  style="margin-bottom: 30px">
                    <a class="btn btn-warning" href="SelectTicket.php?id=<?php echo $_GET["id"] ?>"><?php echo($lang("back")); ?></a>
                    <input class="btn btn-primary" type="submit" value="Next" id="<?php echo($lang('next')); ?>">
                </div>
                <?php
                if (isset($_SESSION["Error_Extra"])) {
                    echo "<p><i style='color: red'>" . $_SESSION["Error_Extra"] . "</i></p>";
                    $_SESSION["Error_Extra"] = null;
                }
                ?>
            </form>
        </div>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/clicon" . "/Shared/Footer.html"; ?>
</body>
</html>