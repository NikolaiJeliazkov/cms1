<?php
// TODO: afterdelete
// TODO: processing images



/**
 * This is the model class for table "galleries".
 *
 * The followings are the available columns in table 'galleries':
 * @property string $GalleryId
 * @property string $ArticleId
 * @property string $GalleryOrder
 *
 * The followings are the available model relations:
 * @property Articles $article
 * @property Images[] $images
 */
class Galleries extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Galleries the static model class
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
		return 'galleries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ArticleId, GalleryOrder', 'required'),
			array('ArticleId, GalleryOrder', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GalleryId, ArticleId, GalleryOrder', 'safe', 'on'=>'search'),
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
			'images' => array(self::HAS_MANY, 'Images', 'GalleryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GalleryId' => '',
			'ArticleId' => 'ArticleId',
			'GalleryOrder' => '#',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
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
		$criteria->compare('GalleryId',$this->GalleryId,false);
		$criteria->compare('ArticleId',$this->ArticleId,false);
		$criteria->compare('article.LangId',Yii::app()->language,false);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort'=>
					array(
							'defaultOrder'=>array(
									'GalleryOrder' => CSort::SORT_DESC,
							),
							'attributes'=>array(),
					),
				'pagination'=>false,

		));
	}

	public function afterSave() {
		$dir = realpath('./').'/galleries/'.$this->GalleryId;
		@mkdir($dir);
		@mkdir($dir.'/tmb');
		return parent::afterSave();
	}

	protected function beforeDelete()
	{
		Images::model()->deleteAll('GalleryId = '.$this->GalleryId);
		return parent::beforeDelete();
	}

	protected function afterDelete()
	{
		Articles::model()->deleteAll('ArticleId = '.$this->ArticleId);
		$dir = realpath('./').'/galleries/'.$this->GalleryId;
		$d = glob($dir.'/tmb/*');
		foreach($d as $file) unlink($file);
// 		array_walk($d, 'unlink');
		rmdir($dir.'/tmb');
		$d = glob($dir.'/*');
		foreach($d as $file) unlink($file);
// 		array_walk($d, 'unlink');
		rmdir($dir);
		return parent::afterDelete();
	}


}