<?php
if (isset($_POST['submit'])) {
    session_start();
    $date = $_POST["date"];
    $time = $_POST["time"];
    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";
    createTransacton($conn, $total);
    createFriendDelivery(
        $conn,
        $_SESSION["userid"],
        $_SESSION["friend"]["name"],
        $_SESSION["friend"]["lat"],
        $_SESSION["friend"]["long"],
        $order = "DELIVERY",
        $date,
        $time
    );

    unset($_SESSION["friend"]);

    header("location: ../delivery/friend-result.php");
    exit();
} else {
    header("location: ../member");
    exit();
}
