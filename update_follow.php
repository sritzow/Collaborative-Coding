<?php
session_start();

try {
	$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));

	if (isset($_POST['follow'], $_POST['project_id'], $_SESSION['user_id'])) {
		$project_query = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
		$project_query->execute(array($_POST['project_id']));
		if ($project_query->rowCount() > 0) {
			$project = $project_query->fetch();
			$auth_query = $pdo->prepare("SELECT * FROM project_auths WHERE user_id = ? AND project_id = ?");
			$auth_query->execute(array($_SESSION['user_id'], $_POST['project_id']));
			if ($auth_query->rowCount() > 0) {
				$auth = $auth_query->fetch();
				$update = $pdo->prepare("UPDATE project_auths SET following = ? WHERE id = ?");
				$update->execute(array($_POST['follow'] === 'true' ? 1 : 0, $auth['id']));
			} else {
				if ($project['private'] == 0) {
					$insert = $pdo->prepare("INSERT INTO project_auths(user_id, project_id, following) VALUES(?, ?, ?)");
					$insert->execute(array($_SESSION['user_id'], $_POST['project_id'], $_POST['follow'] === 'true' ? 1 : 0));
				}
			}
		}
	}
	die();
} catch(PDOException $e) {
	echo $e->getMessage();
}
echo 'error';
die();
?>