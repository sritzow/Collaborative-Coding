<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "root", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
	
	$query = $pdo->prepare('SELECT * FROM accounts WHERE lower(username) = lower(?)');
	$result = $query->execute(array($username));
	
	if ($result) {
		$obj = $query->fetch();
		if ($obj != null) {
			$hashed = hash('sha512', $password);
			if ($obj['password'] == $hashed) {
				$_SESSION['user_id'] = $obj['id'];
				$_SESSION['session_id'] = session_id();
				$query = $pdo->prepare('UPDATE accounts SET session_id = ? WHERE id = ?');
				$query->execute(array(session_id(), $obj['id']));
			}
		}
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

header('Location: index.html');
die();
?>