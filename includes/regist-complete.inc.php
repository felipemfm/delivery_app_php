<?php if (isset($_POST["submit"])) {
    session_start();
    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";
    $id = $_SESSION["id"];
    creatUser($conn, $_SESSION["id"], $_SESSION["email"], $_SESSION["password"], $_SESSION["name"], $_SESSION['postal_code'], $_SESSION['postal_info'], $_SESSION['lat'], $_SESSION['long']);
    header("location: ../member/regist-result.php");
    exit();
} else {
    header("location: ../member");
    exit();
}
