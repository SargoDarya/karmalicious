<?php

require_once('config.php');
require_once('classes/class.user.php');

if(!isset($_GET['user'])) die('please specify ?user=USERNAME_OR_ID');

if(isset($_GET['user']) && !is_numeric($_GET['user'])) {
	$res = mysql_query("SELECT id FROM users WHERE username='".mysql_real_escape_string($_GET['user'])."' LIMIT 1");
	if(mysql_num_rows($res)) {
		$res = mysql_fetch_assoc($res);
		$userID = $res['id'];
	} else {
		$userID = false;
	}
	if($userID === false) die('no user found by that name');
} elseif(isset($_GET['user']) && is_numeric($_GET['user'])) {
	$userID = $_GET['user'];
}

$user = new User($userID);

function drawText(&$handle, $text, $fontSize=12, $x=0, $y=0, $color='#FFFFFF', $align=1) {
	// font drawing
	$draw = new ImagickDraw();
	$color = new ImagickPixel('#FFFFFF');
	$background = new ImagickPixel('none');
	
	/* Font properties */
	$draw->setFont('arial.ttf');
	$draw->setFontSize($fontSize);
	$draw->setFillColor($color);
	$draw->setStrokeAntialias(true);
	$draw->setTextAntialias(true);
	$draw->setTextAlignment($align);
	$draw->translate($x, $y);

	$metrics = $handle->queryFontMetrics($draw, $text);
	
	$draw->annotation(0, 0+$metrics['ascender'], $text);
	
	$handle->drawImage($draw);
}

$path = 'images/';

// Create new objects from png's
$image = new Imagick($path . 'bg1.png');
$mask = new Imagick($path . 'alphamask.png');
$info = new Imagick($path . 'image_template.png');
$icon = new Imagick($path . 'yyicon.png');


// IMPORTANT! Must activate the opacity channel
// See: http://www.php.net/manual/en/function.imagick-setimagematte.php
$image->setImageMatte(1); 

// Create composite of two images using DSTIN
// See: http://www.imagemagick.org/Usage/compose/#dstin
$image->compositeImage($info, Imagick::COMPOSITE_DEFAULT, 0, 0);
$image->compositeImage($icon, Imagick::COMPOSITE_DEFAULT, 10, 10);
$image->compositeImage($mask, Imagick::COMPOSITE_COPYOPACITY, 0, 0);

drawText($image, $user->getUsername(), 26, 110, 16);
drawText($image, $user->getLevel(), 30, 462, 12);

drawText($image, '#'.$user->getRank(), 14, 155, 76, '#FFFFFF', 2);
drawText($image, $user->getTotalKarma(), 14, 267, 76, '#FFFFFF', 2);
drawText($image, 'not available', 14, 412, 76, '#FFFFFF', 2);

// Write image to a file.
$image->writeImage('tmp/newimage.png');

// And/or output image directly to browser
header("Content-Type: image/png");
echo $image;

?>