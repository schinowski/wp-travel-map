<?php
class SCh_Map {
	function __construct(){
		$data = [
			'image' => array(
				'url'    => 'map.jpg',
				'height' => 0,
				'width'  => 0,
				),
			'points' => array(
				array(
					'id'     => 0,
					'x'      => 100,
					'y'      => 200,
					'url'    => 'test1.php',
					'title'  => 'Test point 1',
					'color'  => '00FF00',
					'active' => true,
					'icon'   => array(
						'url'    =>'point.jpg',
						'height' => 10,
						'width'  => 10,
						),
					),
				array(
					'id'     => 1,
					'x'      => 200,
					'y'      => 300,
					'url'    => 'test2.php',
					'title'  => 'Test point 2',
					'color'  => '00FFF0',
					'active' => true,
					'icon'   => array(
						'url'    =>'point.jpg',
						'height' => 10,
						'width'  => 10,
						),
					),
				array(
					'id'     => 2,
					'x'      => 300,
					'y'      => 50,
					'url'    => 'test3.php',
					'title'  => 'Test point 3',
					'color'  => '00FFFF',
					'active' => true,
					'icon'   => array(
						'url'    =>'point.jpg',
						'height' => 10,
						'width'  => 10,
						),
					),
				),
			'connections' => array(
				array(
					'from'   => 0,
					'to'     => 2,
					'dotted' => false,
					),
				array(
					'from'   => 0,
					'to'     => 1,
					'dotted' => true,
					),
				),
		];

		$this->img = $data['image'];
		$imgsize = getimagesize($this->img['url']);
		$this->img['height'] = $imgsize[1];
		$this->img['width'] = $imgsize[0];
		$this->points = $data['points'];
		$this->connections = $data['connections'];
	}

	private function SCh_generate_points(){
		foreach($this->points as $point){
			?>
				<div id="<?php echo $point['id']; ?>" class="SChPoint" onclick="alert('<?php echo $point['title'];?>')" style="top: <?php echo ($point['y'] - ($point['icon']['height'])/2);?>px; left: <?php echo ($point['x'] - ($point['icon']['width'])/2);?>px; background-image:url('<?php echo $point['icon']['url'];?>'); padding-left: <?php echo ($point['icon']['width'] + 5); ?>px;"/><?php echo $point['title'];?></div>
			<?php
			}
	}

	public function SCh_print_map(){
		echo '<img src="map.php" height="'.$this->img['height'].'" width="'.$this->img['width'].'" usemap="#connectors">';
		$this->SCh_generate_points();
	}

	public function SCh_get_connections(){
		return $this->connections;
	}

	public function SCh_get_points(){
		return $this->points;
	}

	public function SCh_get_img(){
		return $this->img;
	}
}