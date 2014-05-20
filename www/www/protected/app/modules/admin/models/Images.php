<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $ImageId
 * @property string $GalleryId
 * @property string $ImageOrder
 * @property string $ImageFileId
 * @property string $ImageBaseName
 * @property string $ImageExtension
 * @property string $ImageTitle
 * @property string $ImageDescription
 * @property string $ImageSize
 * @property string $ImageType
 * @property string $ImagePath
 * @property string $ImageUrl
 * @property string $ImageCreated
 * @property string $ImageUpdated
 *
 * The followings are the available model relations:
 * @property Galleries $gallery
 */
class Images extends CActiveRecord
{
	public $image;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Images the static model class
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
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GalleryId, ImageOrder', 'required'),
			array('GalleryId, ImageOrder', 'length', 'max'=>10),
			array('ImageFileId', 'length', 'max'=>80),
			array('ImageBaseName', 'length', 'max'=>45),
			array('ImageExtension', 'length', 'max'=>6),
			array('ImageTitle, ImagePath, ImageUrl', 'length', 'max'=>256),
			array('ImageSize, ImageType', 'length', 'max'=>20),
			array('ImageDescription, ImageCreated, ImageUpdated', 'safe'),
			array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ImageId, GalleryId, ImageOrder, ImageFileId, ImageBaseName, ImageExtension, ImageTitle, ImageDescription, ImageSize, ImageType, ImagePath, ImageUrl, ImageCreated, ImageUpdated', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Galleries', 'GalleryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ImageId' => '#',
			'GalleryId' => 'Gallery',
			'ImageOrder' => 'Image Order',
			'ImageFileId' => 'Image File',
			'ImageBaseName' => 'Image Base Name',
			'ImageExtension' => 'Image Extension',
			'ImageTitle' => 'Image Title',
			'ImageDescription' => 'Описание',
			'ImageSize' => 'Image Size',
			'ImageType' => 'Image Type',
			'ImagePath' => 'Image Path',
			'ImageUrl' => 'Image Url',
			'ImageCreated' => 'Image Created',
			'ImageUpdated' => 'Image Updated',
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

		$criteria->compare('ImageId',$this->ImageId,false);
		$criteria->compare('GalleryId',$this->GalleryId,false);
		$criteria->compare('ImageOrder',$this->ImageOrder,false);
		$criteria->compare('ImageFileId',$this->ImageFileId,true);
		$criteria->compare('ImageBaseName',$this->ImageBaseName,true);
		$criteria->compare('ImageExtension',$this->ImageExtension,true);
		$criteria->compare('ImageTitle',$this->ImageTitle,true);
		$criteria->compare('ImageDescription',$this->ImageDescription,true);
		$criteria->compare('ImageSize',$this->ImageSize,false);
		$criteria->compare('ImageType',$this->ImageType,true);
		$criteria->compare('ImagePath',$this->ImagePath,true);
		$criteria->compare('ImageUrl',$this->ImageUrl,true);
		$criteria->compare('ImageCreated',$this->ImageCreated,false);
		$criteria->compare('ImageUpdated',$this->ImageUpdated,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>
				array(
						'defaultOrder'=>array(
								'ImageOrder' => CSort::SORT_DESC,
						),
						'attributes'=>array('ImageOrder'),
				),
			'pagination'=>false,

		));
	}

	public function beforeSave() {
		if (!is_null($this->image)) {
			$this->ImageFileId=$this->image->getName();
			$this->ImageBaseName=$this->image->getName();
			$this->ImageExtension='.'.strtolower($this->image->getExtensionName());
			$this->ImageSize=$this->image->getSize();
			$this->ImageType=$this->image->getType();
			$this->ImagePath='/galleries';
			$this->ImageUrl=null;
			$this->ImageCreated=null; //new CDbExpression('NOW()');
			$this->ImageUpdated=null; //new CDbExpression('NOW()');
		}
// 		Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::beforeSave();
	}

	public function afterSave() {
		if (!is_null($this->image)) {
			$dir = realpath('./').$this->ImagePath.'/'.$this->GalleryId;
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $dir.'/tmb/'.$this->ImageBaseName, 200, 130);
			$this->image->saveAs($dir.'/'.$this->ImageBaseName);
		}
// 		Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::afterSave();
	}

	protected function afterDelete()
	{
		$dir = realpath('./').$this->ImagePath.'/'.$this->GalleryId;
		@unlink($dir.'/'.$this->ImageBaseName);
		@unlink($dir.'/tmb/'.$this->ImageBaseName);
		return parent::afterDelete();
	}


}