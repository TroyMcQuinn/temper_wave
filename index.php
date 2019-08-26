<?php

// Parameters
$width = 640;

// Get data
$data = Array();
$dirname = './data/';
$dir = opendir($dirname);
while(($file = readdir($dir)) !== false){
  if(($file != '.') && ($file != '..')){
    $fh = fopen($dirname.$file,'r');
    $file = fread($fh,filesize($dirname.$file));
    $file = explode("\n",$file);
    foreach($file as $line){
      $line = explode(' ',$line);
      if(isset($line[1])){
        $point = $line[1];      
        $data[] = intval(round(($point / 100) * 255)); // Sets a value from 0 to 255.
      }
    }
  }
}

// print_r($data); exit();

// Plot data points as pixels in an image.
$img = imagecreatetruecolor($width,ceil(count($data) / $width));
$x = $y = 0; // Initialize position
foreach($data as $p){
  $color = imagecolorallocate($img,$p,$p,$p);
  imagesetpixel($img,$x,$y,$color);
  $x = ($x >= $width) ? 0 : $x + 1;
  $y = ($x >= $width) ? $y + 1 : $y;
}

header('Content-Type: image/png;');
imagepng($img);





?>