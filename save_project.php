<?php
session_start();
print_r($_POST);

if (isset($_POST['project_description'], $_POST['project_title'], $_POST['project_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$private = isset($_POST['private']) ? 1 : 0;
		$description = htmlentities($_POST['project_description']);
		$project_title = htmlentities($_POST['project_title']);
		$project_id = $_POST['project_id'];
		$query = $pdo->prepare("SELECT projects.id, accounts.private_allowed FROM projects INNER JOIN accounts ON projects.id = ? AND manager_id = ? AND accounts.id = ?");
		$query->execute(array($project_id, $_SESSION['user_id'], $_SESSION['user_id']));
		
		if ($query->rowCount() > 0) {
			$user = $query->fetch();
			if ($user['private_allowed']) {
				$query = $pdo->prepare("UPDATE projects SET name = ?, description = ?, private = ? WHERE id = ?");
				$query->execute(array($project_title, $description, $private, $project_id));
			} else {
				$query = $pdo->prepare("UPDATE projects SET name = ?, description = ? WHERE id = ?");
				$query->execute(array($project_title, $description, $project_id));
			}
		} else {
			header('Location: projects.html');
			die();
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
header('Location: edit_project.html?id=' . $_POST['project_id']);
die();
?>