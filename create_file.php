<?php
session_start();

if (isset($_POST['file_type'], $_POST['folder_id'], $_POST['file_name'])) {
	$file_type = $_POST['file_type'];
	$folder_id = $_POST['folder_id'];
	$file_name = $_POST['file_name'];
	$project_id = $_POST['project_id'];
	
	echo $file_type;
	echo $folder_id;
	echo $file_name;
	if ($folder_id == 0) { $folder_id = null; }
	try {
		echo 'Create connection';
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "root", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		echo 'Select join';
		if ($folder_id == null) {
			$query = $pdo->prepare("SELECT * FROM project_auths WHERE project_id = ? AND user_id = ?");
			$query->execute(array($project_id, $_SESSION['user_id']));
			
			if ($query->rowCount() > 0) {
				$row = $query->fetch();
				if ($file_type === 'Folder') {
					$add = $pdo->prepare("INSERT INTO folders(project_id, folder_name, folder_parent_id) VALUES(?, ?, ?)");
					$add->execute(array($row['project_id'], $file_name, $folder_id));
					echo 'ok';
				}
			}
		} else {
			$query = $pdo->prepare("SELECT * FROM project_auths INNER JOIN folders ON folders.id = ? AND project_auths.project_id = folders.project_id AND project_auths.user_id = ?");
			$query->execute(array($folder_id, $_SESSION['user_id']));
			if ($query->rowCount() > 0) {
				$row = $query->fetch();
				if ($file_type === 'Folder') {
					$add = $pdo->prepare("INSERT INTO folders(project_id, folder_name, folder_parent_id) VALUES(?, ?, ?); UPDATE folders SET has_child = 1 WHERE id = ?");
					$add->execute(array($row['project_id'], $file_name, $folder_id, $folder_id));
					echo 'ok';
				} else {
					$add = $pdo->prepare("INSERT INTO files(name, folder_id, language, extension) VALUES(?, ?, ?, ?); UPDATE folders SET has_child = 1 WHERE id = ?");
					$add->execute(array($file_name, $folder_id, 'javascript', 'js', $folder_id));
					echo 'ok';
				}
			}
		}
		
	} catch (PDOException $e) {
		echo $e;
	}
}

?>