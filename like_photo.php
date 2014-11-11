<?php

include('Image.php');

if(isset($_GET['id'])){
	$image_id = (int)$_GET['id'];
	$image = new Image();
	$image->find_by_pk($image_id);
	$image->LIKES = $image->LIKES + 1;
//	var_dump($image->LIKES);
	$image->update();
	echo $image->LIKES;
} else
	echo "NO";
