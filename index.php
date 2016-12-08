<?php
	/*
	Plugin Name: WP Game Map
	Plugin URI: https://www.sebastianchinowski.pl/
	Description: Manage points on map and connections between them.
	Version: 0.1
	Author: Sebastian Chinowski
	Author URI:  https://www.sebastianchinowski.pl/
	*/
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