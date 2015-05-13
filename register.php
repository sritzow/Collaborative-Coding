<?php
session_start();

$username = trim($_POST['registerUsername']);
$email = trim($_POST['registerEmail']);
$password = trim($_POST['registerPassword']);
$cpassword = trim($_POST['registerCPassword']);

if (isset($username, $email, $password, $cpassword)) {
	try {
		if ($password === $cpassword) {
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
			$query = $pdo->prepare('SELECT * FROM accounts WHERE lower(username) = lower(?) OR lower(email) = lower(?)');
			$query->execute(array($username, $email));
			if ($query->rowCount() == 0) {
				$query = $pdo->prepare('INSERT INTO accounts(username, email, password, session_id) VALUES (?, ?, ?, ?)');
				$result = $query->execute(array($username, $email, hash('sha512', $password), session_id()));
				$_SESSION['user_id'] = $pdo->lastInsertId();
				$_SESSION['session_id'] = session_id();
				$_SESSION['username'] = $username;
			} else {
				$user = $query->fetch();
				if (lower($user['username']) == lower($username)) {
					header('Location: account.html?uname=1');
				}
				if (lower($user['email']) == lower($email)) {
					header('Location: account.html?email=1');
				}
				die();
			}
		} else {
			header('Location: account.html?pwmatch=1');
			die();
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}

header('Location: index.html');
die();
?>