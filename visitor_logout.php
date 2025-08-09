<?php

include_once '../pw_xcon.php';
session_start();
session_unset();
session_destroy();
header("Location:visitor_login.php");
exit();
?>