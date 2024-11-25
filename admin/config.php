<?php

$db_server = 'localhost';
$db_andmebaas = 'tieto';
$db_kasutaja = 'nop';
$db_salasona = 'nop';

	//ühendus andmebaasiga
$yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
$yhendus->set_charset('utf8');
	//ühenduse kontroll
if(!$yhendus){
	die('Ei saa ühendust andmebaasiga');
}
?>