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
		<map name="connectors">
			<area shape="poly" coords="0,0,10,0,5,10" href="#" alt="tutaj">
		</map>
		<?php $map->SCh_print_map();
		?>
		</div>
	</body>
</html>