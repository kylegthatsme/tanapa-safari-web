<?php
	
	require('config/config.php');
	$safaris = array();
	$stmt = $db_conn->prepare("SELECT SAFARI.id, SAFARI.name FROM SAFARI");
	$stmt->execute();
	$stmt->bind_result($safari_id, $safari_name);
	while ($stmt->fetch()) {
		$safaris[] = array(
			"id" => $safari_id,
			"name" => $safari_name
		);
	}
	$stmt->close();

?>

<html>
	<head>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading">Safaris</div>
			<ul class="list-group">
				<?php
					foreach($safaris as $safari) {
						echo "<li class=\"list-group-item\">$safari->name</li>";
					}
				?>
			</ul>
		</div>
	</body>
</html