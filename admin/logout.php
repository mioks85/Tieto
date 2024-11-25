<?php
session_start();
session_unset();
session_destroy();

// suuname kasutaja tagasi sisselogimislehele
header('Location: login.php');
exit();
?>
