<!DOCTYPE html>
<?php
	require("config/config.php");
?>

<?php
if(isset($_POST['edit']))
    {
        $s_name = $_POST['inputName'];
		$s_desc = $_POST['inputDescription'];
		$s_head = $_POST['selectHeader'];
		$s_foot = $_POST['selectFooter'];
		$s_tile = $_POST['selectTile'];
		$s_id = $_POST['ID'];
		$stmt = $db_conn->prepare("UPDATE SAFARI SET name=?, description=?, header_media_id=?, footer_media_id=?, tile_media_id=? WHERE SAFARI.id = ?");
		$stmt->bind_param('ssiiii', $s_name, $s_desc, $s_head, $s_foot, $s_tile, $s_id);
		$stmt->execute();
		$stmt->close();
		header('Location: index.php');
    }
else if(isset($_POST['w_delete']))
	{
        $delete_id = $_POST['ID'];
		$stmt = $db_conn->prepare("DELETE FROM SAFARI_WAYPOINTS WHERE id = ?");
		$stmt->bind_param('i', $delete_id);
		$stmt->execute();
		$stmt->close();
	}
else if(isset($_POST['poi_delete']))
	{
        $delete_id = $_POST['ID'];
		$stmt = $db_conn->prepare("DELETE FROM SAFARI_POINTS_OF_INTEREST WHERE id = ?");
		$stmt->bind_param('i', $delete_id);
		$stmt->execute();
		$stmt->close();
	}

?>
<?php
	if(empty($_GET)){
		header('Location: index.php');
	}
	else{
		if(isset($_GET['id'])){
			$safari = $_GET['id'];
		}
		else{
			header('Location: index.php');
		}
?>
<html>
	<head>
		<title>TANAPA Safari Admin Panel</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="row-fluid">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
				<a class="brand" href="index.php">Safaris</a>
				<ul class="nav nav-tabs">
				</ul>
			</div>
		</div>
		<div class="row-fluid">
			<div class="offset1 span10" id="backer">
				<div id="inner">
					<?php
						$stmt = $db_conn->prepare("SELECT SAFARI.id, SAFARI.name, SAFARI.description, header_media_id, HEADER_MEDIA.type header_media_type, HEADER_MEDIA.url header_media_url, footer_media_id, FOOTER_MEDIA.type footer_media_type, FOOTER_MEDIA.url footer_medi_url, tile_media_id, TILE_MEDIA.type tile_media_type, TILE_MEDIA.url tile_media_url FROM SAFARI JOIN MEDIA HEADER_MEDIA ON HEADER_MEDIA.id = SAFARI.header_media_id JOIN MEDIA FOOTER_MEDIA ON FOOTER_MEDIA.id = SAFARI.footer_media_id JOIN MEDIA TILE_MEDIA ON TILE_MEDIA.id = SAFARI.tile_media_id WHERE SAFARI.id = ?");
						$stmt->bind_param('i', $safari);
						$stmt->execute();
						$stmt->bind_result($safari_id, $safari_name, $safari_description, $header_media_id, $header_media_type, $header_media_url, $footer_media_id, $footer_media_type, $footer_media_url, $tile_media_id, $tile_media_type, $tile_media_url);
						if($stmt->fetch()){ 
							$stmt->close();?>
						
							<form class="form-horizontal" method="POST">
								<?php echo '<input type="hidden" name="ID" value="'.$safari_id.'">'; ?>
								<div class="control-group">
									<label class="control-label" for="inputName">Name</label>
									<div class="controls">
										<input type="text" name="inputName" id="inputName" value="<?php echo $safari_name; ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputDescription">Description</label>
									<div class="controls">
										<textarea rows="3" name="inputDescription" id="inputDescription" width="85%"><?php echo $safari_description; ?></textarea>
									</div>
								<div class="controls-group">
									<label class="control-label" for="selectHeader">Header</label>
									<div class="controls">
										<select name="selectHeader" id="selectHeader">
										<?php
											echo '<option value ="' .$header_media_id. '">';
											echo $header_media_url;
											echo '</option>';
											$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA");
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
								<div class="controls-group">
									<label class="control-label" for="selectFooter">Footer</label>
									<div class="controls">
										<select name="selectFooter" id="selectFooter">
										<?php
											echo '<option value ="' .$footer_media_id. '">';
											echo $footer_media_url;
											echo '</option>';
											$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA");
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
								<div class="controls-group">
									<label class="control-label" for="selectTile">Tile</label>
									<div class="controls">
										<select name="selectTile" id="selectTile">
										<?php
											echo '<option value ="' .$tile_media_id. '">';
											echo $tile_media_url;
											echo '</option>';
											$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA");
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
									<button type="submit" name="edit" class="btn">Edit Safari</button>
								</div>
							</form>	

						<?php
							}
						?>
						<h2>WayPoints</h2>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Sequence</th>
									<th>Latitude</th>
									<th>Longitude</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$stmt = $db_conn->prepare("SELECT SAFARI_WAYPOINTS.id, SAFARI_WAYPOINTS.sequence, SAFARI_WAYPOINTS.latitude, SAFARI_WAYPOINTS.longitude FROM SAFARI_WAYPOINTS WHERE SAFARI_WAYPOINTS.safari_id = ?");
									$stmt->bind_param('i', $safari);
									$stmt->execute();
									$stmt->bind_result($w_id, $w_sequence, $w_lat, $w_lng);
									while($stmt->fetch()){	?>
										<tr>
											<td>
												<?php echo $w_id;?>
											</td>
											<td>
												<?php echo $w_sequence; ?>
											</td>
											<td>
												<?php echo $w_lat; ?>
											</td>
											<td>
												<?php echo $w_lng; ?>
											</td>
											<td>
												<form name="" method="POST" action="">
												<input type="hidden" name="ID" value="<?php echo $w_id;?>">
												<input type="submit" name="w_delete" value="Delete" class="btn btn-danger">
												</form>
											</td>
										</tr>
									<?php
									}
									$stmt->close();
									?>
								</tbody>
							</table>
							<a href='newwp.php' class='btn btn-success'> Add WayPoint </a>
						<h2>Points of Interest</h2>
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Latitude</th>
									<th>Longitude</th>
									<th>Radius</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$stmt = $db_conn->prepare("SELECT SAFARI_POINTS_OF_INTEREST.id, SAFARI_POINTS_OF_INTEREST.name, SAFARI_POINTS_OF_INTEREST.latitude, SAFARI_POINTS_OF_INTEREST.longitude, SAFARI_POINTS_OF_INTEREST.radius FROM SAFARI_POINTS_OF_INTEREST WHERE SAFARI_POINTS_OF_INTEREST.safari_id = ?");
									$stmt->bind_param('i', $safari);
									$stmt->execute();
									$stmt->bind_result($poi_id, $poi_name, $poi_lat, $poi_lng, $poi_radius);
									while($stmt->fetch()){	?>
										<tr>
											<td>
												<?php echo $poi_id;?>
											</td>
											<td>
												<?php echo $poi_name; ?>
											</td>
											<td>
												<?php echo $poi_lat; ?>
											</td>
											<td>
												<?php echo $poi_lng; ?>
											</td>
											<td>
												<?php echo $poi_radius; ?>
											</td>
											<td>
												<form name="" method="POST" action="">
												<input type="hidden" name="ID" value="<?php echo $poi_id;?>">
												<input type="submit" name="poi_delete" value="Delete" class="btn btn-danger">
												</form>
											</td>
										</tr>
									<?php
									}
									$stmt->close();
									?>
								</tbody>
							</table>
							<a href='newpoi.php' class='btn btn-success'>Add Point of Interest</a>
				</div>
			</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php } ?>
