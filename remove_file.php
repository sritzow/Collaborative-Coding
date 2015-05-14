<?php
session_start();
if (isset($_POST['file_type'], $_POST['file_id'], $_POST['project_id'])) {
	$file_type = $_POST['file_type'];
	$file_id = $_POST['file_id'];
	$project_id = $_POST['project_id'];

	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		$query = $pdo->prepare("SELECT * FROM project_auths WHERE project_id = ? AND user_id = ?");
		$query->execute(array($project_id, $_SESSION['user_id']));
		
		if ($query->rowCount() > 0) {
			$row = $query->fetch();
			if ($row['level'] == 2) {
				if ($file_type === 'Folder') {
					$query = $pdo->prepare("SELECT * FROM folders WHERE id = ?");
					$query->execute(array($file_id));
					if ($query->rowCount() > 0) {
						$folder = $query->fetch();
						if ($folder['project_id'] == $project_id && $folder['has_child'] == 0) {
							$query = $pdo->prepare("DELETE FROM folders WHERE id = ?");
							$query->execute(array($folder['id']));
							
							$select = $pdo->prepare("SELECT * FROM folders INNER JOIN files ON folders.folder_parent_id = ? OR files.folder_id = ?");
							$select->execute(array($folder['folder_parent_id'], $folder['folder_parent_id']));
							if ($select->rowCount() == 0) {
								$update = $pdo->prepare("UPDATE folders SET has_child = 0 WHERE id = ?");
								$update->execute(array($folder['folder_parent_id']));
							}
							echo 'ok';
						}					
					}
				} else {
					if ($file_type === 'File') {
						$query = $pdo->prepare("SELECT * FROM files INNER JOIN folders WHERE files.id = ? AND folders.id = files.folder_id");
						$query->execute(array($file_id));
						if ($query->rowCount() > 0) {
							$folder = $query->fetch();
							if ($folder['project_id'] == $project_id) {
								$query = $pdo->prepare("DELETE FROM files WHERE id = ?");
								$query->execute(array($file_id));
								
								$select = $pdo->prepare("SELECT * FROM folders INNER JOIN files ON folders.folder_parent_id = ? OR files.folder_id = ?");
								$select->execute(array($folder['folder_id'], $folder['folder_id']));
								if ($select->rowCount() == 0) {
									$update = $pdo->prepare("UPDATE folders SET has_child = 0 WHERE id = ?");
									$update->execute(array($folder['folder_id']));
								}
								echo 'ok';
							}	
						}
					}
				}
			}
		}	
	} catch (PDOException $e) {
		echo $e;
	}
}
?>