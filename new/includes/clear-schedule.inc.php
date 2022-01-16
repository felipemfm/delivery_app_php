<?php
session_start();
if (isset($_SESSION["userid"])) {
    include_once __DIR__ . "/../includes/dbh.inc.php";

    $sql = "DELETE FROM deliveries_database WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) header("location: ../shopping?error=stmtFailed");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["userid"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../mypage");
    exit;
} else {
    header("location: ../");
    exit;
}
