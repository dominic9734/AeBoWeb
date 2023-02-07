<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: ../user/books.php");
exit;
