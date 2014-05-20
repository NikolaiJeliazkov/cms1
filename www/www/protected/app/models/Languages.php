<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property string $LangId
 * @property string $LangName
 * @property integer $LangActivated
 * @property string $LangOrder
 *
 * The followings are the available model relations:
 * @property Articles[] $articles
 * @property Sitemap[] $sitemaps
 */
class Languages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Languages the static model class
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
		return 'languages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LangId, LangName, LangOrder', 'required'),
			array('LangActivated', 'numerical', 'integerOnly'=>true),
			array('LangId', 'length', 'max'=>2),
			array('LangName', 'length', 'max'=>255),
			array('LangOrder', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('LangId, LangName, LangActivated, LangOrder', 'safe', 'on'=>'search'),
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
			'articles' => array(self::HAS_MANY, 'Articles', 'LangId'),
			'sitemaps' => array(self::HAS_MANY, 'SiteMap', 'LangId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'LangId' => 'Код',
			'LangName' => 'Име',
			'LangActivated' => 'Активен',
			'LangOrder' => '№',
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

		$criteria->compare('LangId',$this->LangId,true);
		$criteria->compare('LangName',$this->LangName,true);
		$criteria->compare('LangActivated',$this->LangActivated);
		$criteria->compare('LangOrder',$this->LangOrder,true);
		$criteria->order = 'LangOrder';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>false,
// 				array(
// 					'defaultOrder'=>array(
// 							'LangOrder' => CSort::SORT_ASC,
// 					),
// 					'attributes'=>array(
// 							'LangId',
// 							'LangName',
// 							'LangActivated',
// 							'LangOrder'
// 					)
// 			),
			'pagination'=>false,
		));
	}

	public static function all()
	{
		$models=self::model()->findAll(array(
				'condition'=>'LangActivated=1',
				'order'=>'LangOrder',
		));
		$a = array();
		foreach($models as $m) array_push($a, $m->LangId);
		return $a;
	}

	protected function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord) {
			$article = Articles::createNew($this->LangId,Yii::t('zii', 'Home'),null,null,null,null,null,Yii::app()->user->id,1,7,null,null);
			$home = SiteMap::createNew(null,$this->LangId,'',$article,'site',null);
			$news = SiteMap::createNew($home->id,$this->LangId,'news',null,'news',null);
			$calendar = SiteMap::createNew($home->id,$this->LangId,'calendar',null,'calendar',null);
			$gallery = SiteMap::createNew($home->id,$this->LangId,'gallery',null,'gallery',null);
		}
	}
}