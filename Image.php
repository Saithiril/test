<?php
include_once('ARModel.php');

class Image extends ARModel
{
	public function tableName(){
		return 'IMAGES';
	}

	public function dbName()
	{
		return 'saithiril_images';
	}

	public function rules() {
		return array(
			'update'=>array('LIKES', 'PATH'),
		);
	}
}