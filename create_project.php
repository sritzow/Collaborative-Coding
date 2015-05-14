<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$query = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
		$query->execute(array($_SESSION['user_id']));
		$acc = $query->fetch();
		
		$query = $pdo->prepare('SELECT projects.id, manager_id, name, description FROM `projects` INNER JOIN `project_auths` ON project_auths.following = 1 AND project_auths.project_id = projects.id AND project_auths.user_id = ? AND project_auths.level >= 1 OR projects.manager_id = ? GROUP BY projects.id, manager_id, name, description');
		$query->execute(array($_SESSION['user_id'], $_SESSION['user_id']));
		
		if ($query->rowCount() < $acc['max_projects']) {
			$query = $pdo->prepare("INSERT INTO projects(name, manager_id, description) VALUES(?, ?, ?)");
			$query->execute(array('My New Project', $_SESSION['user_id'], 'A description for my new project.'));
			
			$query = $pdo->prepare("INSERT INTO project_auths(user_id, project_id, level) VALUES(?, ?, ?)");
			$query->execute(array($_SESSION['user_id'], $pdo->lastInsertId(), 1));
		}
		echo 'ok';
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
}
?>