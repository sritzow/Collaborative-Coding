<?php
session_start();


if (isset($_POST['username'])) {
	$username = $_POST['username'];
} else if (isset($_POST['email'])) {
	$email = $_POST['email'];
}

try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "root", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
	
	$query = null;
	$result = null;
	
	if (isset($username)) {
		$query = $pdo->prepare('SELECT * FROM accounts WHERE lower(username) = lower(?)');
		$result = $query->execute(array($username));
	} else if (isset($email)) {
		$query = $pdo->prepare('SELECT * FROM accounts WHERE lower(email) = lower(?)');
		$result = $query->execute(array($email));
	}
	
	if ($result) {
		$obj = $query->fetch();
		if ($obj != null) {
			echo 'notok';
			die();
		}
	}
	echo 'ok';
	die();
} catch(PDOException $e) {
	echo $e->getMessage();
}
echo 'error';
?>