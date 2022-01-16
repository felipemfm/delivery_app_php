<?php 
session_start();
if(isset($_POST["submit"])){
$id = $_POST["friend_id"];
}else{
    header("location: ../index.php");
    exit();
}
include_once __DIR__ . "/../includes/dbh.inc.php";
include_once __DIR__ . "/../includes/functions.inc.php";

removeFriend($conn,$_SESSION["userid"], $id);

header("location: ../delivery/friend-list.php");
exit();