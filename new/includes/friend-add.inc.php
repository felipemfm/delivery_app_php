<?php
session_start();
if (isset($_POST["submit"])) {
    include_once __DIR__ . "/../includes/dbh.inc.php";
    include_once __DIR__ . "/../includes/functions.inc.php";
    addFriend($conn, $_SESSION["userid"], $_POST["friend_id"]);
    $_SESSION["temp"]["id"] = $_POST["friend_id"];
    $_SESSION["temp"]["name"] = $_POST["friend_name"];
    $_SESSION["temp"]["avatar"] = $_POST["friend_avatar"];

    header("location: ../delivery/friend-add.php");
    exit();
} else {
    header("location: ../index.php");
    exit();
}
