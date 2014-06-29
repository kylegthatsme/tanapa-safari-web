<!DOCTYPE html>
<?php
	require("config/config.php");
?>


<html>
	<head>
		<title>TANAPA Safari Admin Panel</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
								
		<script>
			$(document).ready(function(){
				$("#mediaFileInput").on("change", function(e){
					console
					if (e.target.value) {
					/*
						var formData = new FormData(e.target.form);
						$.ajax({
							url: 'media.php',  //Server script to process data
							type: 'POST',
							success: function(data){
								location.reload();
							},
							// Form data
							data: formData,
							//Options to tell jQuery not to process data or worry about content-type.
							cache: false,
							contentType: false,
							processData: false
						});   */
					}
				});
			});           
		</script>

	</head>
	<body>
		<?php
			include 'navbar.php';
		?>
		<div class="row-fluid">
			<div class="offset1 span10" id="backer">
				<div id="inner">
					<div class="accordion" id="loc-acc">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="btn btn-large btn-block btn-inverse" data-toggle="collapse" data-parent="#loc-acc" href="#collapseOne">
									Media
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse">
								<div class="accordion-inner">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>URL</th>
											</tr>
										</thead>
										<tbody>
														
											<?php

												$stmt = $db_conn->prepare("SELECT MEDIA.url, MEDIA.id FROM MEDIA");
												$stmt->execute();
												$stmt->bind_result($media_url, $media_id);
												while($stmt->fetch()) {
											?>                      
												<tr>
													<td><?php echo $media_id?></td>
													<td><a href="<?php echo substr($media_url, 1); ?>"><?php echo $media_url?></a></td>
												</tr>
											<?php
												}

												$stmt->close();
											?>
										<tbody>
									</table>
									<form id="mediaFileInputForm">
										<input type="file" id="mediaFileInput" name="file">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
