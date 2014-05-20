<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property string $PostId
 * @property string $PostPubDate
 * @property string $ArticleId
 * @property string $PostShortContent
 *
 * The followings are the available model relations:
 * @property Articles $article
 */
class Posts extends CActiveRecord
{
	public $image;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Posts the static model class
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
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PostPubDate, ArticleId', 'required'),
			array('ArticleId', 'length', 'max'=>10),
			array('PostShortContent', 'safe'),
			array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('PostId, PostPubDate, ArticleId, PostShortContent', 'safe', 'on'=>'search'),
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
			'PostId' => '#',
			'PostPubDate' => 'Дата на публикуване',
			'ArticleId' => 'Article',
			'PostShortContent' => 'Кратък текст',
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
		$criteria->compare('PostId',$this->PostId,false);
		$criteria->compare('PostPubDate',$this->PostPubDate,false);
		$criteria->compare('ArticleId',$this->ArticleId,false);
		$criteria->compare('PostShortContent',$this->PostShortContent,true);
		$criteria->compare('article.LangId',Yii::app()->language,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>
				array(
					'defaultOrder'=>array(
							'PostPubDate' => CSort::SORT_DESC,
// 							'PostId' => CSort::SORT_DESC,
					),
					'attributes'=>array(
							'PostId',
							'PostPubDate',
							'article.ArticleCreateTime',
					)
			),
			'pagination'=>array(
					'pageSize'=>20,
			),

		));
	}

	public function afterSave() {
// 		Yii::trace(CVarDumper::dumpAsString($this->image),'vardump');
		if (!is_null($this->image)) {
			$uploaddir = realpath('./').'/images/news/';
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $uploaddir.$this->PostId.'.png');
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $uploaddir.'/thumbs/'.$this->PostId.'.png', 120, 90);
		}
		return parent::afterSave();
	}

	protected function afterDelete()
	{
		Articles::model()->deleteAll('ArticleId = '.$this->ArticleId);
		$uploaddir = realpath('./').'/images/news/';
		@unlink($uploaddir.$this->PostId.'.png');
		@unlink($uploaddir.'/thumbs/'.$this->PostId.'.png');
		return parent::afterDelete();
	}

}