<!DOCTYPE html>
<?php
	require("config/config.php");
?>

<?php
if(isset($_POST['delete']))
    {
        $delete_id = $_POST['ID'];
		$stmt = $db_conn->prepare("DELETE FROM REPORT WHERE id = ?");
		$stmt->bind_param('i', $delete_id);
		$stmt->execute();
		$stmt->close();
		header('Location: userreports.php');
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
						$stmt = $db_conn->prepare("SELECT REPORT.id, REPORT.user_id, REPORT.latitude, REPORT.longitude, REPORT.time, REPORT.content, MEDIA.type, MEDIA.url, REPORT_TYPE.name FROM REPORT JOIN MEDIA ON REPORT.report_media_id = MEDIA.id JOIN REPORT_TYPE ON REPORT.report_type_id = REPORT_TYPE.id WHERE REPORT.id = ?");
						$stmt->bind_param('i', $_GET['id']);
						$stmt->execute();
						$stmt->bind_result($r_id, $user_id, $latitude, $longitude, $time, $r_content, $m_type, $m_url, $r_type);
						$m_url = ltrim($m_url, "/");
						if($stmt->fetch()) {
					?>		
							<h2 class="text-center">User <?php echo $user_id;?>: <?php echo $r_type;?></h2><br />
							<div class="row-fluid">
								<div class="span5">
									<?php
										if(strpos($m_type, "image") === 0){
									?>
											<img src="<?php echo substr($m_url, 1);?>">
									<?php
										}
										if(strpos($m_type, "video") === 0){
									?>
											<video width="320" height="240" controls>
												<source src="<?php echo substr($m_url, 1);?>" type="<?php echo $m_type;?>">
												Your Browser Does Not Support the Video Tag
											</video>
									<?php
										}
										if(strpos($m_type, "audio") === 0){
									?>
											<audio controls>
												<source src="<?php echo substr($m_url, 1);?>" type="<?php echo $m_type;?>">
												Your Browser Does Not Support the Audio Tag
											</audio>
									<?php
										}
									?>
								</div>
								<div class="offset1 span6">
									<table class="table">
										<tr>
											<td>Time</td>
											<td><?php echo $time;?></td>
										<tr>
										<tr>
											<td>Longitude</td>
											<td><?php echo $longitude;?></td>
										</tr>
										<tr>
											<td>Latitude</td>
											<td><?php echo $latitude;?></td>
										</tr>
										<tr>
											<td>Content</td>
											<td><p><?php echo $r_content;?></p></td>
										</tr>
										<tr>
											<td>
												<form method="get" action="<?php echo substr($m_url, 1);?>">
													<button type="submit" class="btn">Download Media</button>
												</form>
											</td>
										</tr>
										<tr>
											<form name="" method=POST action="">
												<input type="hidden" name="ID" value="<?php echo $r_id; ?>">
													<td>
														<input type="submit" name="delete" value="Delete" class="btn btn-block btn-danger">
													</td>
												</form>
										</tr>
									</table>
								</div>

							<tr>
							</tr>
					<?php
						}

						$stmt->close();
					?>
						<tbody>
					</table>
<script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(<?php echo $latitude . ',' . $longitude;?>),
          zoom: 10
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

		<?php
			if($stmt->fetch()){
		?>
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(<?php echo $latitude . ',' . $longitude;?>),
				});

				marker.setMap(map);
		<?php
			}
			$stmt->close();
		?>
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
						<div id="map-canvas"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	}
?>
