<?php
	session_start();

	if(isset($_SESSION['username']))
		unset($_SESSION['username']);
        setcookie("username", "", -1);

	header("Location: index.php");

?>