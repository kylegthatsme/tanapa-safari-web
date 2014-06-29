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
		$stmt = $db_conn->prepare("UPDATE ANIMAL_GROUP SET name=?, description=?, header_media_id=?, footer_media_id=?, tile_media_id=? WHERE ANIMAL_GROUP.id = ?");
		$stmt->bind_param('ssiiii', $s_name, $s_desc, $s_head, $s_foot, $s_tile, $s_id);
		$stmt->execute();
		$stmt->close();
		header('Location: index.php');
    }

else if(isset($_POST['poi_delete']))
	{
        $delete_id = $_POST['ID'];
		$stmt = $db_conn->prepare("DELETE FROM ANIMAL_SPECIFIC WHERE id = ?");
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
			$group = $_GET['id'];
		}
		else{
			header('Location: index.php');
		}
?>
<html>
	<head>
		<title>TANAPA Safari Admin Panel</title>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style type="text/css">
			#map-canvas{ height: 400px }
		</style>
		<script type="text/javascript"
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAiJYDrTbqabJ4a0T2mtzQwfpCOJwX443M&sensor=false">
		</script>
	</head>
	<body>
		<?php
			include 'navbar.php';
		?>
		<div class="row-fluid">
			<div class="offset1 span10" id="backer">
				<div id="inner">
					<?php
						$stmt = $db_conn->prepare("SELECT ANIMAL_GROUP.id, ANIMAL_GROUP.name, ANIMAL_GROUP.description, header_media_id, HEADER_MEDIA.type header_media_type, HEADER_MEDIA.url header_media_url, footer_media_id, FOOTER_MEDIA.type footer_media_type, FOOTER_MEDIA.url footer_medi_url, tile_media_id, TILE_MEDIA.type tile_media_type, TILE_MEDIA.url tile_media_url FROM ANIMAL_GROUP JOIN MEDIA HEADER_MEDIA ON HEADER_MEDIA.id = ANIMAL_GROUP.header_media_id JOIN MEDIA FOOTER_MEDIA ON FOOTER_MEDIA.id = ANIMAL_GROUP.footer_media_id JOIN MEDIA TILE_MEDIA ON TILE_MEDIA.id = ANIMAL_GROUP.tile_media_id WHERE ANIMAL_GROUP.id = ?");
						$stmt->bind_param('i', $group);
						$stmt->execute();
						$stmt->bind_result($group_id, $group_name, $group_description, $header_media_id, $header_media_type, $header_media_url, $footer_media_id, $footer_media_type, $footer_media_url, $tile_media_id, $tile_media_type, $tile_media_url);
						if($stmt->fetch()){ 
							$stmt->close();?>
						
							<form class="form-horizontal" method="POST">
								<?php echo '<input type="hidden" name="ID" value="'.$group_id.'">'; ?>
								<div class="control-group">
									<label class="control-label" for="inputName">Name</label>
									<div class="controls">
										<input type="text" name="inputName" id="inputName" value="<?php echo $group_name; ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputDescription">Description</label>
									<div class="controls">
										<textarea rows="3" name="inputDescription" id="inputDescription" width="85%"><?php echo $group_description; ?></textarea>
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
									<button type="submit" name="edit" class="btn">Edit Animal Group</button>
								</div>
							</form>	

						<?php
							}
						?>

							
						<div class="accordion" id="specific-acc">
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="btn btn-large btn-block btn-inverse" data-toggle="collapse" data-parent="#specific-acc" href="#collapseTwo">
										Specific Animals
									</a>
								</div>
								<div id="collapseTwo" class="accordion-body collapse">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Description</th>
												<th>Header Image</th>
												<th>Footer Image</th>
												<th>Tile Image</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$stmt = $db_conn->prepare("SELECT as.id, as.name, as.description, ".
													"m.url, m1.url, m2.url FROM ANIMAL_SPECIFIC as LEFT JOIN MEDIA m ON as.header_media_id = m.id LEFT JOIN MEDIA m1 ON ".
													"as.footer_media_id = m1.id LEFT JOIN MEDIA m2 ON as.tile_media_id = m2.id".
													" WHERE as.group_id= ?");
												$stmt->bind_param('i', $group);
												$stmt->execute();
												$stmt->bind_result($poi_id, $poi_name, $poi_description, $header_url, $footer_url, $tile_url);
												while($stmt->fetch()) {	
													$header_url = ltrim($header_url, "/");
													$footer_url = ltrim($footer_url, "/");
													$tile_url = ltrim($tile_url, "/");
												?>
													<tr>
														<td>
															<?php echo $poi_id;?>
														</td>
														<td>
															<?php echo $poi_name; 
																	$p_names[] = $poi_name;?>
														</td>
														<td>
															<?php echo $poi_description; 
																	//$p_names[] = $poi_name;?>
														</td>
														<td>
															<img class='offset3 span6' src="<?php echo $header_url;?>">
														</td>
														<td>
															<img class='offset3 span6' src="<?php echo $footer_url;?>">
														</td>
														<td>
															<img class='offset3 span6' src="<?php echo $tile_url;?>">
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
										<a href='newspecificanimal.php' class='btn btn-success'>Add Specific Animal</a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php } ?>
