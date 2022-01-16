<?php
if (isset($_POST['submit'])) {
    session_start();
    $input = $_POST['input'];
    $pwd = $_POST['password'];

    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";

    if (emptyInputLogin($input, $pwd) !== false) {
        $_SESSION["error"] = "emptyInput";
        header("location: ../member/");
        exit();
    }

    loginUser($conn, $input, $input, $pwd);
} else {
    header("location: ../member/");
    exit();
}
