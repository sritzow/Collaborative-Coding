<?php
session_start();
session_regenerate_id();
$email = trim($_POST['loginEmail']);
$password = trim($_POST['loginPassword']);

try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
	
	$query = $pdo->prepare('SELECT * FROM accounts WHERE lower(email) = lower(?)');
	$query->execute(array($email));
	
	if ($query->rowCount() > 0) {
		$obj = $query->fetch();
		if ($obj != null) {
			$hashed = hash('sha512', $password);
			if ($obj['password'] == $hashed) {
				$_SESSION['user_id'] = $obj['id'];
				$_SESSION['session_id'] = session_id();
				$_SESSION['username'] = $obj['username'];
				$query = $pdo->prepare('UPDATE accounts SET session_id = ? WHERE id = ?');
				$query->execute(array(session_id(), $obj['id']));
			} else {
				header("Location: account.html?login=0");
				die();
			}
		}
	}
} catch(PDOException $e) {
	echo $e->getMessage();
}

header('Location: index.html');
die();
?>