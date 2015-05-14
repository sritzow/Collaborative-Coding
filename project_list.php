<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "collab", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$query = $pdo->prepare('SELECT projects.id, manager_id, name, description FROM `projects` INNER JOIN `project_auths` ON project_auths.following = 1 AND project_auths.project_id = projects.id AND project_auths.user_id = ? OR projects.manager_id = ? GROUP BY projects.id, manager_id, name, description');
		$query->execute(array($_SESSION['user_id'], $_SESSION['user_id']));
		if ($query->rowCount() > 0) {
			while ($row = $query->fetch()) { 
				$owner_query = $pdo->prepare('SELECT * FROM `accounts` WHERE id = ?');
				$owner_query->execute(array($row['manager_id']));
				$owner = $owner_query->fetch()['username'];
				?>
				<div class = "row">
					<div class = "col-md-12"> 
						<a href = "project.html?id=<?php echo $row['id']; ?>">
						<?php echo htmlspecialchars($row['name']); ?>
						</a> 
						<?php if ($row['manager_id'] == $_SESSION['user_id']) { ?>
						<span class = "pull-right"><a href = "edit_project.html?id=<?php echo $row['id']; ?>">Edit</a></span>					
						<?php } else { ?>
						<span class = "pull-right">Project Owner: <?php echo htmlspecialchars($owner); ?></span>
						<?php } ?>
						
						<div class = "row">
							<div class = "col-md-12">
								<?php echo htmlspecialchars($row['description']); ?>
							</div>
						</div>
					</div>
				</div>
				<br/>
			<?php
			}
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
} else {
	header('Location: account.html');
	die();
}
?>