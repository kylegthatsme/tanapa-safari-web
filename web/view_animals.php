<!DOCTYPE html>
<?php
	require("config/config.php");
?>

<?php
if(isset($_POST['delete']))
    {
        $delete_id = $_POST['ID'];
		$stmt = $db_conn->prepare("DELETE FROM ANIMAL_SPECIFIC WHERE group_id = ?");
		$stmt->bind_param('i', $delete_id);
		$stmt->execute();
		$stmt->close();
		$stmt = $db_conn->prepare("DELETE FROM ANIMAL_GROUP WHERE id = ?");
		$stmt->bind_param('i', $delete_id);
		$stmt->execute();
		$stmt->close();
		header('Location: view_animals.php');
    }
?>
<html>
	<head>
		<title>TANAPA Safari Admin Panel</title>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<?php
			include 'navbar.php';
		?>
		<div class="row-fluid">
			<div class="offset1 span10" id="backer">
				<div id="inner">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
								<th>Header</th>
								<th>Footer</th>
								<th>Tile</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$stmt = $db_conn->prepare("SELECT ANIMAL_GROUP.id, ANIMAL_GROUP.name, ANIMAL_GROUP.description, header_media_id, HEADER_MEDIA.type header_media_type, HEADER_MEDIA.url header_media_url, footer_media_id, FOOTER_MEDIA.type footer_media_type, FOOTER_MEDIA.url footer_medi_url, tile_media_id, TILE_MEDIA.type tile_media_type, TILE_MEDIA.url tile_media_url FROM ANIMAL_GROUP LEFT JOIN MEDIA HEADER_MEDIA ON HEADER_MEDIA.id = ANIMAL_GROUP.header_media_id LEFT JOIN MEDIA FOOTER_MEDIA ON FOOTER_MEDIA.id = ANIMAL_GROUP.footer_media_id LEFT JOIN MEDIA TILE_MEDIA ON TILE_MEDIA.id = ANIMAL_GROUP.tile_media_id");
							$stmt->execute();
							$stmt->bind_result($group_id, $group_name, $group_description, $header_media_id, $header_media_type, $header_media_url, $footer_media_id, $footer_media_type, $footer_media_url, $tile_media_id, $tile_media_type, $tile_media_url);
							while($stmt->fetch()){
								echo '<form name="" method="POST" action="">';
								echo '<tr>';
								echo '<td>';
								echo $group_id;
								echo '</td><td>';
								echo $group_name;
								echo '</td><td>';
								echo $group_description;
								echo '</td><td>';
								echo '<img src="';
								echo ltrim($header_media_url, "/");
								echo '"/>';
								echo '</td><td>';
								echo '<img src="';
								echo ltrim($footer_media_url, "/");
								echo '"/>';
								echo '</td><td>';
								echo '<img src="';
								echo ltrim($tile_media_url, "/");
								echo '"/>';
								echo '</td><td>';
								echo '<a href="animaldetails.php?id='.$group_id.'" class="btn btn-block btn-primary">Details</a>';
								echo '</td><td>';
								echo '<input type="hidden" name="ID" value="'.$group_id.'">';
								echo '<input type="submit" name="delete" value="Delete" class="btn btn-block btn-danger">';
								echo '</td></tr>';
								echo '</form>';
							}
							$stmt->close();
						?>
						</tbody>
					</table>
					<a href="newanimalgroup.php" class="btn btn-success">Add a new Animal Group</a>
				</div>
			</div>
		</div>
	</body>
</html>
