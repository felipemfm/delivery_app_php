
<?php

$serverName = 'mysql81.conoha.ne.jp';
$dBUsername = "wii36_cv37a_a8tfy5wj";
$dBPassword = "P_edt8_ppGnrwrv";
$dBName = "wii36_ponpon_db";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}
