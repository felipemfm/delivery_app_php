<?php
if(isset($_POST)){
    session_start();
    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";

    registerDrone($conn, $_SESSION["userid"]);
    header("location: ../mypage/index.php");
    exit();
} else {
    header("location: ../mypage");
    exit();
}