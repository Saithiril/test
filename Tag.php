<?php
include_once('ARModel.php');

class Tag extends ARModel
{
	public function tableName(){
		return 'tags';
	}

	public function dbName()
	{
		return 'saithiril_images';
	}
}