<?php
/*----------  Init map object  ----------*/

include 'map.class.php';
$map = new SCh_Map;
$points = $map->SCh_get_points();
$img = $map->SCh_get_img();

/*----------  Functions printing lines  ----------*/

function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
{
    /* this way it works well only for orthogonal lines
    imagesetthickness($image, $thick);
    return imageline($image, $x1, $y1, $x2, $y2, $color);
    */
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
        return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
        round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
}

function imagepatternedline($image, $xstart, $ystart, $xend, $yend, $color, $thickness=1, $pattern="11110000") 
{ 
   $pattern=(!strlen($pattern)) ? "1" : $pattern; 
   $x=$xend-$xstart; 
   $y=$yend-$ystart; 
   $length=floor(sqrt(pow(($x),2)+pow(($y),2))); 
   $fullpattern=$pattern; 
   while (strlen($fullpattern)<$length) $fullpattern.=$pattern; 
   if (!$length) { 
      if ($fullpattern[0]) imagefilledellipse($image, $xstart, $ystart, $thickness, $thickness, $color); 
      return; 
   } 
   $x1=$xstart; 
   $y1=$ystart; 
   $x2=$x1; 
   $y2=$y1; 
   $mx=$x/$length; 
   $my=$y/$length; 
   $line=""; 
   for($i=0;$i<$length;$i++){ 
      if (strlen($line)==0 or $fullpattern[$i]==$line[0]) { 
         $line.=$fullpattern[$i]; 
      }else{ 
         $x2+=strlen($line)*$mx; 
         $y2+=strlen($line)*$my; 
         if ($line[0]) imageline($image, round($x1), round($y1), round($x2-$mx), round($y2-$my), $color); 
         $k=1; 
         for($j=0;$j<$thickness-1;$j++) { 
            $k1=-(($k-0.5)*$my)*(floor($j*0.5)+1)*2; 
            $k2= (($k-0.5)*$mx)*(floor($j*0.5)+1)*2; 
            $k=1-$k; 
            if ($line[0]) { 
               imageline($image, round($x1)+$k1, round($y1)+$k2, round($x2-$mx)+$k1, round($y2-$my)+$k2, $color); 
               if ($y) imageline($image, round($x1)+$k1+1, round($y1)+$k2, round($x2-$mx)+$k1+1, round($y2-$my)+$k2, $color); 
               if ($x) imageline($image, round($x1)+$k1, round($y1)+$k2+1, round($x2-$mx)+$k1, round($y2-$my)+$k2+1, $color); 
            } 
         } 
         $x1=$x2; 
         $y1=$y2; 
         $line=$fullpattern[$i]; 
      } 
   } 
   $x2+=strlen($line)*$mx; 
   $y2+=strlen($line)*$my; 
   if ($line[0]) imageline($image, round($x1), round($y1), round($xend), round($yend), $color); 
   $k=1; 
   for($j=0;$j<$thickness-1;$j++) { 
      $k1=-(($k-0.5)*$my)*(floor($j*0.5)+1)*2; 
      $k2= (($k-0.5)*$mx)*(floor($j*0.5)+1)*2; 
      $k=1-$k; 
      if ($line[0]) { 
         imageline($image, round($x1)+$k1, round($y1)+$k2, round($xend)+$k1, round($yend)+$k2, $color); 
         if ($y) imageline($image, round($x1)+$k1+1, round($y1)+$k2, round($xend)+$k1+1, round($yend)+$k2, $color); 
         if ($x) imageline($image, round($x1)+$k1, round($y1)+$k2+1, round($xend)+$k1, round($yend)+$k2+1, $color); 
      } 
   } 
} 

/*----------  Determine file format  ----------*/

$file = $img['url'];

switch(pathinfo($file)['extension']){
	case "jpg": $image = @imagecreatefromjpeg($file);
	break;
	case "jpeg": $image = @imagecreatefromjpeg($file);
	break;
	case "png": $image = @imagecreatefrompng($file);
	break;
}

/*----------  Define colors  ----------*/

$black = imagecolorallocate($image, 0,0,0);
$white = imagecolorallocate($image, 255,255,255);
$red = imagecolorallocate($image, 255,0,0);
$green = imagecolorallocate($image, 0,255,0);
$blue = imagecolorallocate($image, 0,0,255);

/*----------  Generate connections  ----------*/

foreach($map->SCh_get_connections() as $connection){
  if($connection['active']){
  	if($connection['dotted']){
  		imagepatternedline($image, $points[$connection['from']]['x'], $points[$connection['from']]['y'], $points[$connection['to']]['x'], $points[$connection['to']]['y'], ${$connection['color']}, $connection['thickness'], $connection['pattern']);
  	} else {
  		imagelinethick($image, $points[$connection['from']]['x'], $points[$connection['from']]['y'], $points[$connection['to']]['x'], $points[$connection['to']]['y'], ${$connection['color']}, $connection['thickness']);
  	}	
  }
}

/*----------  Generate image  ----------*/

header ('Content-Type: image/png');
imagepng($image);

/*----------  Free the memory  ----------*/

imagedestroy($image);
?>