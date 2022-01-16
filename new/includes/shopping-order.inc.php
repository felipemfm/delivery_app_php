<?php
if (isset($_POST['submit'])) {
    session_start();
    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";
    if($_POST["check"] == 1){
        $time = $_POST['time'];
    }else{
        $time = "";
    }
    // var_dump ($_SESSION["store"]);
    // exit;
    createTransacton($conn, $_POST['total']);
    createShoppingDelivery(
        $conn,
        $_SESSION["userid"],
        $_SESSION["store"]["name"],
        $_SESSION["store"]["lat"],
        $_SESSION["store"]["long"],
        $_POST['order_info'],
        $time
    );

    unset($_SESSION["store"], $_SESSION["cart"]);

    header("location: ../shopping/menu-result.php");
    exit();
} else {
    header("location: ../member");
    exit();
}
