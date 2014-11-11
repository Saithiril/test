<?php
include_once('ARModel.php');

class Tagging extends ARModel
{
	public $count = 0;

	private $page_count = 0;
	private $tags = array();

	public function tableName(){
		return 'tagging';
	}

	public function dbName()
	{
		return 'saithiril_images';
	}

	public function getDataByTags($tags, $sort, $start=0, $count=10) {
		function test($a, $b) {
			if(empty($a))
				return "$a where name=?";
			return "$a or name=?";
		}

		if($sort==0)
			$sort_field = "created_time";
		elseif($sort==1)
			$sort_field = "LIKES";

		$this->page_count = $count;
		$this->tags = $tags;

		if(empty($tags)) {
			$result = $this->getDbConnection()->prepare("select SQL_CALC_FOUND_ROWS * from images join (select IMAGE_ID from tagging group by IMAGE_ID) as image_id on ID=image_id order by $sort_field desc limit $start, $count;");

		} else {
			$count = count($tags);
			$tag_names = array_reduce($tags, "test");
			$result = $this->getDbConnection()->prepare("select SQL_CALC_FOUND_ROWS * from images join (select IMAGE_ID from tagging where TAG_ID = any(select ID from tags $tag_names) group by IMAGE_ID having count(*) = $count) as image_id on ID=image_id order by $sort_field desc limit $start, $count;");
		}
		for($i=0; $i<$count; $i++)
			$result->bindValue($i+1, $tags[$i]);
		$result->execute();
		$items = $result->fetchAll(PDO::FETCH_ASSOC);

		$count = $this->getDbConnection()->prepare("SELECT FOUND_ROWS() as count");
		$count->execute();
		$r = $count->fetch();
		$this->count = $r['count'];
		return $items;
	}

	public function to_page($page){
		return $this->getDataByTags($this->tags, ($page - 1) * $this->page_count, $this->page_count);
	}
}
//select SQL_CALC_FOUND_ROWS * from images join (select IMAGE_ID from tagging where TAG_ID = any(select ID from tags where NAME='РўРµРі1' or NAME='РўРµРі4' ) group by IMAGE_ID having count(*) = 2) as image_id on ID=image_id order by created_time
//select IMAGE_ID from tagging where TAG_ID = any(select ID from tags where NAME='РўРµРі3') group by IMAGE_ID