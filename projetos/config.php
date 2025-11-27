<?php
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', '');
	define('BASE', 'concessionariaberg');
	define('PORT', 3307);
	

	$conn = new MySQLi(HOST,USER,PASS,BASE,PORT);