<?php
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
	try {
		$pdo = new PDO("mysql:host=127.0.0.1;dbname=projects", "root", "", array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION));
		
		$query = $pdo->prepare('SELECT * FROM `projects` INNER JOIN `project_auths` ON project_auths.project_id = projects.id AND project_auths.user_id = ? AND project_auths.level >= 1 OR projects.manager_id = ?');
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
						<?php echo $row['name']; ?>
						<span class = "pull-right">Project Owner: <?php echo $owner; ?></span>
						</a>
						<div class = "row">
							<div class = "col-md-12">
								<?php echo $row['description']; ?>
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