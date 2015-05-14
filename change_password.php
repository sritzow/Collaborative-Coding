<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$account_query = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
		$account_query->execute(array($_SESSION['user_id']));
		$account = $account_query->fetch();
		
		if ($account['password'] == hash('sha512', $_POST['changeCurrent'])) {
			if ($_POST['changeNew'] == $_POST['changeNewAgain']) {
				$update = $pdo->prepare("UPDATE accounts SET password = ? WHERE id = ?");
				$update->execute(array(hash('sha512', $_POST['changeNew']), $_SESSION['user_id']));
				header('Location: account.html?success=1');
				die();
			}
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
header('Location: account.html?fail=1');
die();
?>