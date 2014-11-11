<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Images</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script src="/main.js"></script>
	<!--	<link rel="stylesheet" type="text/css" href=""/>-->
<body>
<?php
include('Image.php');
include('Tag.php');
include('Tagging.php');

$count_on_page = 2;

$image = new Tagging();
$page = 1;
$sort = 0;

if(isset($_GET['sort']))
	$sort = $_GET['sort'];

if(isset($_GET['page']))
	$page = $_GET['page'];

if(isset($_GET['tags'])) {
	$images = $image->getDataByTags(preg_split("/,/", $_GET['tags']), $sort, ($page - 1) * $count_on_page , $count_on_page);
	$tagstring = "tags={$_GET['tags']}";
} else {
	$images = $image->getDataByTags(array(), $sort, ($page - 1) * $count_on_page ,$count_on_page);
	$tagstring = "";
}

foreach($images as $item) {
	echo "<image src='{$item['PATH']}'/><br/>";
	echo "<p>Понравилось: <span id='likes_count_{$item['ID']}'>{$item['LIKES']}</span></p>";
	echo "<input type='button' value='Мне понравилось' onclick='like_photo(event, {$item['ID']})'/><br/>";
}
$preview = $page - 1;
$next = $page + 1;
$page_count = ceil($image->count / $count_on_page);
if($page > 1)
	echo "<a href='image_list.php?$tagstring&page=$preview'>Предыдущая</a>";
echo "<div>Страница $page из $page_count</div>";

if($page < $page_count)
	echo "<a href='image_list.php?$tagstring&page=$next'>Следующая</a>";
?>
</body>
</html>