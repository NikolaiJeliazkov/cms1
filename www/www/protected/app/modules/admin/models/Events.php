<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property string $EventId
 * @property string $ArticleId
 * @property string $EventStartDate
 * @property string $EventEndDate
 * @property string $EventShortContent
 *
 * The followings are the available model relations:
 * @property Articles $article
 */
class Events extends CActiveRecord
{
	public $image;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ArticleId, EventStartDate', 'required'),
			array('ArticleId', 'length', 'max'=>10),
			array('EventEndDate, EventShortContent', 'safe'),
			array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('EventId, ArticleId, EventStartDate, EventEndDate, EventShortContent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'article' => array(self::BELONGS_TO, 'Articles', 'ArticleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'EventId' => '#',
			'ArticleId' => 'Article',
			'EventStartDate' => 'Начало',
			'EventEndDate' => 'Край',
			'EventShortContent' => 'Кратък текст',
			'image' => 'Зареди файл',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('article');
		$criteria->compare('EventId',$this->EventId,false);
		$criteria->compare('ArticleId',$this->ArticleId,false);
		$criteria->compare('EventStartDate',$this->EventStartDate,false);
		$criteria->compare('EventEndDate',$this->EventEndDate,false);
		$criteria->compare('EventShortContent',$this->EventShortContent,true);
		$criteria->compare('article.LangId',Yii::app()->language,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>
				array(
						'defaultOrder'=>array(
								'EventStartDate' => CSort::SORT_DESC,
								//'EventId' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'EventId',
								'EventStartDate',
								'EventEndDate',
								'article.ArticleCreateTime',
						)
				),
			'pagination'=>array(
						'pageSize'=>20,
				),

		));
	}

	public function beforeSave() {
		if ($this->EventEndDate=='0000-00-00' || trim($this->EventEndDate)=='') {
			$this->EventEndDate=null;
		}
		return parent::beforeSave();
	}

	public function afterSave() {
		// 		Yii::trace(CVarDumper::dumpAsString($this->image),'vardump');
		if (!is_null($this->image)) {
			$uploaddir = realpath('./').'/images/calendar/';
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $uploaddir.$this->EventId.'.png');
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $uploaddir.'/thumbs/'.$this->EventId.'.png', 120, 90);
		}
		return parent::afterSave();
	}

	protected function afterDelete()
	{
		Articles::model()->deleteAll('ArticleId = '.$this->ArticleId);
		$uploaddir = realpath('./').'/images/calendar/';
		@unlink($uploaddir.$this->EventId.'.png');
		@unlink($uploaddir.'/thumbs/'.$this->EventId.'.png');
		return parent::afterDelete();
	}

}