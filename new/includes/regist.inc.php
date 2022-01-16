<?php
if (isset($_POST["submit"])) {
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
        header("location: ../member/regist.php?error=emptyInput");
        exit();
    }
    if (empty($postal_info)) {
        header("location: ../member/regist.php?error=invalidPostal");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../member/regist.php?error=invalidEmail");
        exit();
    }
    if (userExists($conn, $uid, $email) !== false) {
        header("location: ../member/regist.php?error=usesExist");
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
