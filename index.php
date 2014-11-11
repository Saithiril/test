<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Images</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
    <!--	<link rel="stylesheet" type="text/css" href=""/>-->
<body>
<?php
include('Image.php');
include('Tag.php');
include('Tagging.php');

$tag = new Tag();
$tags = $tag->find();

echo "<form method='POST' action='show_image.php'>";
	echo "<select multiple name='tags[]'>";
	foreach($tags as $item)
		echo "<option value='{$item->NAME}'>{$item->NAME}</option>";
?>
	</select>
	<div>
		<input checked type="radio" name="sort" value="0"> По времени<Br>
		<input type="radio" name="sort" value="1"> По лайкам<Br>
	</div>
	<input type='submit' value='Поиск' name='search'/>
</body>
</html>