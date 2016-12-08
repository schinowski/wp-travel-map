<?php
	include 'map.class.php';
	$map = new SCh_Map;
?>
<html>
	<head>
		<title>WP Travel Map</title>
		<link rel="stylesheet" type="text/css" href="map.css">
	</head>
	<body>
		<div class="SChMap">
		
		<?php 
		$map->SCh_print_connections();
		$map->SCh_print_map();
		?>
		</div>
	</body>
</html>