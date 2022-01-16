<?php
if (isset($_POST["submit"])) {
    require_once __DIR__ . "/../includes/dbh.inc.php";
    require_once __DIR__ . "/../includes/functions.inc.php";
    require __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    session_start();

    if (isset($_FILES['fname'])) {
        $tempfile = $_FILES['fname']['tmp_name']; // 一時ファイル名
        $filename = "../images/avatar/" . $_SESSION["userid"] . ".jpg"; // 本来のファイル名
        if (is_uploaded_file($tempfile))
            move_uploaded_file($tempfile, $filename);
        setUserAvatar($conn, $_SESSION["userid"]);
        $_SESSION["avatar"] = $_SESSION["userid"];
    }

    if (!empty($_POST["user-name"]) && $_SESSION["username"] != $_POST["user-name"]) {
        $type = "user_name";
        $edit = $_POST["user-name"];
        $_SESSION["username"] = $_POST["user-name"];
        editUserProfile($conn, $edit, $_SESSION["userid"], $type);
    }
    if (!empty($_POST["email"]) && $_SESSION["email"] != $_POST["email"]) {
        $type = "user_email";
        $edit = $_POST["email"];
        $_SESSION["email"] = $_POST["email"];
        editUserProfile($conn, $edit, $_SESSION["userid"], $type);
    }
    if (!empty($_POST["password"])) {
        $type = "user_password";
        $edit = $_POST["password"];
        editUserProfile($conn, $edit, $_SESSION["userid"], $type);
    }
    if (!empty($_POST["postal-code"]) && $_SESSION["postal_code"] != $_POST["postal-code"]) {
        $postal_info = getPostalInfo($_POST["postal-code"], $_ENV['GEOCODE_KEY_API']);
        if (!empty($postal_info)) {
            editUserAddress($conn, $_POST["postal-code"], $postal_info["address"], $postal_info["lat"], $postal_info["long"], $_SESSION["userid"]);
            $_SESSION['postal_code'] = $_POST["postal-code"];
            $_SESSION['postal_info'] = $postal_info["address"];
            $_SESSION["lat"] = $postal_info["lat"];
            $_SESSION["long"] = $postal_info["long"];
        }
    }

    header("location: ../mypage");
    exit;
} else {
    header("location: ../mypage");
    exit;
}
