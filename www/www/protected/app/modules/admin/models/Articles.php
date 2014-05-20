<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property string $ArticleId
 * @property string $LangId
 * @property string $ArticleCreateTime
 * @property string $ArticleModifyTime
 * @property integer $ArticleAuthor
 * @property integer $ArticleActivated
 * @property string $ArticleOptions
 * @property string $ArticleValidFrom
 * @property string $ArticleValidTo
 * @property string $ArticleTitle
 * @property string $ArticleSubtitle
 * @property string $ArticleContent
 * @property string $ArticleTags
 * @property string $ArticleMetaKeywords
 * @property string $ArticleMetaDescription
 *
 * The followings are the available model relations:
 * @property Users $articleAuthor
 * @property Languages $lang
 * @property Events[] $events
 * @property Galleries[] $galleries
 * @property Posts[] $posts
 */
class Articles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Articles the static model class
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
		return 'articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('LangId, ArticleCreateTime, ArticleAuthor, ArticleTitle, ArticleContent', 'required'),
				array('ArticleAuthor, ArticleActivated', 'numerical', 'integerOnly'=>true),
				array('LangId', 'length', 'max'=>2),
				array('ArticleOptions', 'length', 'max'=>10),
				array('ArticleModifyTime, ArticleValidFrom, ArticleValidTo, ArticleTitle, ArticleSubtitle, ArticleContent, ArticleTags, ArticleMetaKeywords, ArticleMetaDescription', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('ArticleId, LangId, ArticleCreateTime, ArticleModifyTime, ArticleAuthor, ArticleActivated, ArticleOptions, ArticleValidFrom, ArticleValidTo, ArticleTitle, ArticleSubtitle, ArticleContent, ArticleTags, ArticleMetaKeywords, ArticleMetaDescription', 'safe', 'on'=>'search'),
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
				'articleAuthor' => array(self::BELONGS_TO, 'Users', 'ArticleAuthor'),
				'lang' => array(self::BELONGS_TO, 'Languages', 'LangId'),
				'events' => array(self::HAS_MANY, 'Events', 'ArticleId'),
				'galleries' => array(self::HAS_MANY, 'Galleries', 'ArticleId'),
				'posts' => array(self::HAS_MANY, 'Posts', 'ArticleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'ArticleId' => '#',
				'ArticleCreateTime' => 'Дата на създаване',
				'ArticleModifyTime' => 'Дата на последна промяна',
				'ArticleAuthor' => 'Автор',
				'ArticleActivated' => 'Активна',
				'ArticleOptions' => 'Покажи',
				'ArticleValidFrom' => 'Валидна след',
				'ArticleValidTo' => 'Валидна до',
				'ArticleTitle' => 'Заглавие',
				'ArticleSubtitle' => 'Подзаглавие',
				'ArticleContent' => 'Текст',
				'ArticleTags' => 'Ключови думи',
				'ArticleMetaKeywords' => 'MetaKeywords',
				'ArticleMetaDescription' => 'MetaDescription',
				'LangId' => 'Lang',
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

		$criteria->compare('ArticleId',$this->ArticleId,false);
		$criteria->compare('LangId',$this->LangId,false);
		$criteria->compare('ArticleCreateTime',$this->ArticleCreateTime,false);
		$criteria->compare('ArticleModifyTime',$this->ArticleModifyTime,false);
		$criteria->compare('ArticleAuthor',$this->ArticleAuthor);
		$criteria->compare('ArticleActivated',$this->ArticleActivated);
		$criteria->compare('ArticleOptions',$this->ArticleOptions,false);
		$criteria->compare('ArticleValidFrom',$this->ArticleValidFrom,false);
		$criteria->compare('ArticleValidTo',$this->ArticleValidTo,false);
		$criteria->compare('ArticleTitle',$this->ArticleTitle,true);
		$criteria->compare('ArticleSubtitle',$this->ArticleSubtitle,true);
		$criteria->compare('ArticleContent',$this->ArticleContent,true);
		$criteria->compare('ArticleTags',$this->ArticleTags,true);
		$criteria->compare('ArticleMetaKeywords',$this->ArticleMetaKeywords,true);
		$criteria->compare('ArticleMetaDescription',$this->ArticleMetaDescription,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public static function createNew(
			$LangId=false,
			$ArticleTitle=false,
			$ArticleSubtitle=null,
			$ArticleContent=null,
			$ArticleTags=null,
			$ArticleMetaKeywords=null,
			$ArticleMetaDescription=null,
			$ArticleAuthor=false,
			$ArticleActivated=0,
			$ArticleOptions=7,
			$ArticleValidFrom=null,
			$ArticleValidTo=null
	) {
		$article = new Articles;
		$article->LangId = $LangId;
		$article->ArticleCreateTime = date('Y-m-d H:i:s');
		$article->ArticleModifyTime = $article->ArticleCreateTime;
		$article->ArticleAuthor = $ArticleAuthor;
		$article->ArticleActivated = $ArticleActivated;
		$article->ArticleOptions = $ArticleOptions;
		$article->ArticleValidFrom = $ArticleValidFrom;
		$article->ArticleValidTo = $ArticleValidTo;
		$article->ArticleTitle = $ArticleTitle;
		$article->ArticleSubtitle = $ArticleSubtitle;
		$article->ArticleContent = $ArticleContent;
		$article->ArticleTags = $ArticleTags;
		$article->ArticleMetaKeywords = $ArticleMetaKeywords;
		$article->ArticleMetaDescription = $ArticleMetaDescription;
		$article->save(false);
		return $article;
	}

	public function beforeSave() {
		if ($this->isNewRecord)
			$this->ArticleCreateTime = new CDbExpression('NOW()');
		$this->ArticleModifyTime = new CDbExpression('NOW()');
		return parent::beforeSave();
	}

// 	public function behaviors()
// 	{
// 		return array(
// 				'StatesBinaryField'=>array(
// 						'class'=>'StatesBinaryFieldBehavior',
// 						'attribute'=>'ArticleOptions',
// 						'data'=>array(
// 								'1'=>'Автор',
// 								'2'=>'Дата на създаване',
// 								'4'=>'Дата на промяна',
// 						),
// 				)
// 		);
// 	}
}