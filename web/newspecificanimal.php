<!DOCTYPE html>
<?php
	require("config/config.php");
?>

<?php
if(isset($_POST['submit']))
    {

		$stmt = $db_conn->prepare("INSERT INTO ANIMAL_SPECIFIC(name, description, group_id, ".
			"header_media_id, footer_media_id), tile_media_id)) values(?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssii', 
			$_POST['inputName'], 
			$_POST['inputDescription'], 
			$_POST['selectGroup'], 
			$_POST['selectHeaderImage'],
			$_POST['selectFooterImage'],
			$_POST['selectTileImage']);
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
			$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA LEFT JOIN REPORT ON MEDIA.id = REPORT.report_media_id");
			$stmt->execute();
			$stmt->bind_result($media_url, $media_id);
			$dom_opts = "";
			while($stmt->fetch()){
				$dom_opts .= '<option value ="'.$media_id.'" >';
				$dom_opts .= $media_url;
				$dom_opts .= '</option>';
			}
			$stmt->close();
		?>
		<div class="row-fluid">
			<div class="offset1 span10" id="backer">
				<div id="inner">
					<form class="form-horizontal" method="POST">
						<div class="control-group">
							<label class="control-label" for="inputName">Name</label>
							<div class="controls">
								<input type="text" name="inputName" id="inputName" placeholder="input animal name">
							</div>
						</div>
						<div class="controls-group">
							<label class="control-label" for="selectHeaderImage">Header Image</label>
							<div class="controls">
								<select name="selectHeaderImage" id="selectHeaderImage">
								<?php echo $dom_opts; ?>
								</select>
							</div>
						</div>
						<div class="controls-group">
							<label class="control-label" for="selectFooterImage">Footer Image</label>
							<div class="controls">
								<select name="selectFooterImage" id="selectFooterImage">
								<?php echo $dom_opts; ?>
								</select>
							</div>
						</div>
						<div class="controls-group">
							<label class="control-label" for="selectHeaderImage">Tile Image</label>
							<div class="controls">
								<select name="selectTileImage" id="selectTileImage">
								<?php echo $dom_opts; ?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="inputDescription">Description</label>
							<div class="controls">
								<input type="text" name="inputDescription" id="inputDescription" placeholder="input animal description">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectGroup">Animal Group</label>
							<div class="controls">
								<select name="selectGroup" id="selectGroup">
								<?php
									$stmt = $db_conn->prepare("SELECT ANIMAL_GROUP.id, ANIMAL_GROUP.name FROM ANIMAL_GROUP");
									$stmt->execute();
									$stmt->bind_result($s_id, $s_name);
									while($stmt->fetch()){
										echo '<option value ="'.$s_id.'" >';
										echo $s_name;
										echo '</option>';
									}
									$stmt->close();
								?>
								</select>
							</div>
						</div>
							<button type="submit" name="submit" class="btn">Add Specific Animal</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</body>
</html>
