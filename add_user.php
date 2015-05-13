<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'], $_POST['username'], $_POST['project_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$query = $pdo->prepare('SELECT * FROM projects WHERE id = ? AND manager_id = ?');
		$query->execute(array($_POST['project_id'], $_SESSION['user_id']));
		if ($query->rowCount() > 0) {
			$username = $_POST['username'];
			$query = $pdo->prepare("SELECT * FROM accounts WHERE lower(username) = lower(?)");
			$query->execute(array($username));
			
			if ($query->rowCount() > 0) {
				$acc = $query->fetch();
				
				$query = $pdo->prepare("SELECT * FROM project_auths WHERE user_id = ? AND project_id = ?");
				$query->execute(array($acc['id'], $_POST['project_id']));
				
				if ($query->rowCount() == 0) {
					$query = $pdo->prepare("INSERT INTO project_auths(user_id, project_id) VALUES(?, ?)");
					$query->execute(array($acc['id'], $_POST['project_id']));
				} else {
					$query = $pdo->prepare("DELETE FROM project_auths WHERE user_id = ? AND project_id = ?");
					$query->execute(array($acc['id'], $_POST['project_id']));
				}
			}
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}

header('Location: edit_project.html?id=' . $_POST['project_id']);
die();
?>