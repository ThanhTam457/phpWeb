<?php
include "func/func.php";
session_start();
$_SESSION = [];
session_destroy();
session_start();
$_SESSION['msg'] = "Logged out successfully!";
$_SESSION['msg_class'] = "warning";
header("Location: index.php");