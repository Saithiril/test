<?php

$tags = array();
$sort = 0;

if(isset($_POST['search'])) {
	if(isset($_POST['sort']))
		$sort = $_POST['sort'];

	if(isset($_POST['tags']))
		$tags = $_POST['tags'];

	if(!empty($tags)){
		$tagstring = implode(",", $tags);
		header("Location: image_list.php?tags=$tagstring&sort=$sort");
		return;
	}
	header("Location: image_list.php?sort=$sort");
}