<?php
class ARModel
{
	const BELONGS_TO = 1;
	const HAS_MANY = 2;
	const HAS_ONE = 3;
	const MANY_MANY = 4;

	public static $db = null;

	private $_attributes=array();

	public function getDbConnection()
	{
		if(self::$db!==null)
			return self::$db;
		else
		{
			$dsn = "mysql:host=localhost;dbname={$this->dbName()}";
			self::$db = new PDO($dsn, 'saithiril', 'Neverwinter2');
			return self::$db;
		}
	}

	public function find_by_pk($pk) {
		$data = $this->find("{$this->getPK()}=:id", array(':id'=>$pk));
		if(!empty($data))
			$this->_attributes = $data[0]->_attributes;
		else
			$this->_attributes = array();
	}

	public function find($condition="", $params="") {
		if(empty($condition))
			$result = $this->getDbConnection()->prepare("select * from {$this->tableName()};");
		else
			$result = $this->getDbConnection()->prepare("select * from {$this->tableName()} where $condition;");
		if(empty($params))
			$result->execute();
		else
			$result->execute($params);
		$items = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($this));

		return $items;
	}

	public function save() {
		$fields = implode(", ", array_keys($this->_attributes));
		$keys = array_map(function ($x) {return ":$x";}, array_keys($this->_attributes));
		$values = implode(",",$keys);
		$result = $this->getDbConnection()->prepare("insert into {$this->tableName()}($fields) values($values);");
		$result->execute(array_combine ($keys, array_values($this->_attributes)));

		$pk = $this->getDbConnection()->lastInsertId();
		return $pk;
	}

	public function update(){
		$rules = $this->rules();
		if(isset($rules['update']))
			$fields = $rules['update'];
		else
			return;

		$object = $this;
		$field_list = array_map(function ($x) {return "$x=:$x";}, $fields);
		$values = implode(",",$field_list);
		$result = $this->getDbConnection()->prepare("update {$this->tableName()} set {$values} where {$this->getPK()}=:id;");
		$keys = array_map(function ($x) {return ":$x";}, $fields);
		$data = array_combine ($keys, array_values(array_map(function ($x) use($object) {return $object->$x;}, $fields)));
		$data[':id'] = $this->{$this->getPK()};
		$result->execute($data);
	}

	public function delete($pk) {
		$result = $this->getDbConnection()->prepare("delete from {$this->tableName()} where {$this->getPK()} = :pk;");
		$result->execute(
			array(':pk'=>$pk)
		);
	}

	public function rules() {
		return array();
	}

	protected function getPK() {
		return 'ID';
	}

	public function dbName()
	{
		return get_class($this);
	}

	public function relations() {
		return array();
	}

	public function tableName()
	{
		return get_class($this);
	}

	public function attributeLabels() {
		return array();
	}

	public function __get($name) {
		if(isset($this->_attributes[$name]))
			return $this->_attributes[$name];
		return array();
	}

	public function __set($name,$value) {
		$this->_attributes[$name] = $value;
	}

	public function __isset($name) {
		if (isset($this->_attributes[$name]))
			return true;
		else
			return false;
	}

	public function __unset($name) {
		if (isset($this->_attributes[$name]))
			unset($this->_attributes[$name]);
	}

	public function __call($name,$parameters) {
		return parent::__call($name, $parameters);
	}

	public  function __construct($attributes = array()) {
		$this->_attributes = $attributes;
	}
}