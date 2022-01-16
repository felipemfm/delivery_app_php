<?php
session_start();
if (isset($_SESSION["userid"])) {
    session_start();
    session_unset();
    session_destroy();
}
header("location: ../member");
exit;
