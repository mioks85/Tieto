<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php
session_start();
if (!isset($_SESSION['tuvastamine'])) {
	header('Location: login.php');
	exit();
}
if(isset($_POST['logout'])){
	session_destroy();
	setcookie("login", 1, time()-7200);
	header('Location: admin/index.php');
	exit();
}
?>