<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$query = $pdo->prepare('SELECT * FROM projects WHERE id = ? AND manager_id = ?');
		$query->execute(array($_POST['project_id'], $_SESSION['user_id']));
		if ($query->rowCount() > 0) {
			echo $_POST['can_edit'];
			echo $_POST['user_id'];
			echo $_POST['project_id'];
			$query = $pdo->prepare('UPDATE project_auths SET level = ? WHERE user_id = ? AND project_id = ?');
			$query->execute(array(($_POST['can_edit'] === 'true' ? 1 : 0), $_POST['user_id'], $_POST['project_id']));
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>