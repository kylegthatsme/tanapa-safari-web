<!DOCTYPE html>
<?php
	require("config/config.php");
?>

<?php
if(isset($_POST['submit']))
    {
        $p_name = $_POST['inputName'];
        $p_description = $_POST['inputDescription'];
		$p_group  = $_POST['selectGroup'];
		$p_img = $_POST['selectImage'];
		$stmt = $db_conn->prepare("INSERT INTO ANIMAL_SPECIFIC(name, description, group_id, media_id) values(?, ?, ?, ?)");
		$stmt->bind_param('ssii', $p_name, $p_description, $p_group, $p_img);
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
			include 'navbar.php'
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
							<label class="control-label" for="selectImage">Image</label>
							<div class="controls">
								<select name="selectImage" id="selectImage">
								<?php
									$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA LEFT JOIN REPORT ON MEDIA.id = REPORT.report_media_id");
									$stmt->execute();
									$stmt->bind_result($media_url, $media_id);
									while($stmt->fetch()){
										echo '<option value ="'.$media_id.'" >';
										echo $media_url;
										echo '</option>';
									}
									$stmt->close();
								?>
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
