<?php
if (isset($_POST["submit"])) {
    session_start();
    $uid = $_POST["id"];
    $name = $_POST["name"];
    $postal_code = $_POST["postal-code"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";
    require __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $postal_info = getPostalInfo($postal_code, $_ENV['GEOCODE_KEY_API']);
    if (emptyInputRegis($uid, $postal_code, $email, $pwd) !== false) {
        $_SESSION["error"] = "emptyInput";
        header("location: ../member/regist.php");
        exit();
    }
    if (empty($postal_info)) {
        $_SESSION["error"] = "postal";
        header("location: ../member/regist.php");
        exit();
    }
    if (invalidEmail($email) !== false) {
        $_SESSION["error"] = "email";
        header("location: ../member/regist.php");
        exit();
    }
    if (invalidUid($uid) !== false) {
        $_SESSION["error"] = "userid";
        header("location: ../member/regist.php");
        exit();
    }
    if (userExists($conn, $uid) !== false) {
        $_SESSION["error"] = "userExists";
        header("location: ../member/regist.php");
        exit();
    }

    session_start();
    $_SESSION['id'] = $uid;
    $_SESSION['name'] = $name;
    $_SESSION['postal_code'] = $postal_code;
    $_SESSION['postal_info'] = $postal_info["address"];
    $_SESSION["lat"] = $postal_info["lat"];
    $_SESSION["long"] = $postal_info["long"];
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $pwd;
    header("location: ../member/regist-confirm.php");
    exit();
} else {
    header("location: ../member");
    exit();
}
