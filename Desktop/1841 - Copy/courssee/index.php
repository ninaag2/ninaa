<?php
session_start();
$title = ' Internet Question Database ';
ob_start();
include 'templates/home.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>