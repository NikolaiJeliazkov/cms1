<?php

class Message extends CActiveRecord
{

  var $tab_name='Message';

	/**
	 * Returns the static model of the specified AR class.
	 * This method is required by all child classes of CActiveRecord.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return $this->tab_name;
	}


  public function setTableName($name) {
    $this->tab_name =$name;
  }


  public function setDbConnection($db) {
    self::$db =$db;
  }


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('language','length','max'=>16),
			array('id', 'numerical', 'integerOnly'=>true)
		);
	}


	public function safeAttributes() {
		return 'id,language,translation';
	}
	
}