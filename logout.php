<?php
// logout.php
require_once 'db_connect.php';
session_unset();
session_destroy();
header('Location: signin.php');
exit;
