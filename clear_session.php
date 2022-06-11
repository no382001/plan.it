<?php
session_start();
$_SESSION['query-result'] = null;
$_SESSION['try-url'] = null;
header("Location: index.php");
?>