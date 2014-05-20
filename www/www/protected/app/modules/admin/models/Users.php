<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $UserId
 * @property string $UserEmail
 * @property string $UserName
 * @property string $UserPassword
 * @property integer $UserActivated
 *
 * The followings are the available model relations:
 * @property Articles[] $articles
 * @property Authitem[] $authitems
 */
class Users extends CActiveRecord
{
	public $UserPassword_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('UserEmail, UserName', 'required'),
				array('UserPassword, UserPassword_repeat', 'required', 'on'=>'create'),
				array('UserActivated', 'numerical', 'integerOnly'=>true),
				array('UserEmail, UserName, UserPassword', 'length', 'max'=>255),
				array('UserPassword', 'compare'),
				array('UserPassword_repeat', 'safe'),
				array('UserEmail', 'email'),

				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('UserId, UserEmail, UserName', 'safe', 'on'=>'search'),
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
				'articles' => array(self::HAS_MANY, 'Articles', 'ArticleAuthor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'UserId' => '#',
				'UserEmail' => 'Email',
				'UserName' => 'Име',
				'UserPassword' => 'Парола',
				'UserPassword_repeat' => 'Повторете паролата',
				'UserActivated' => 'Статус',
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

		$criteria->compare('UserId',$this->UserId);
		$criteria->compare('UserEmail',$this->UserEmail,true);
		$criteria->compare('UserName',$this->UserName,true);
		$criteria->compare('UserPassword',$this->UserPassword,true);
		$criteria->compare('UserActivated',$this->UserActivated);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort'=>array(
						'defaultOrder'=>array(
								'UserId' => CSort::SORT_ASC,
						),
						'attributes'=>array(
								'UserId',
								'UserName',
								'UserEmail',
						)
				),
				'pagination'=>array(
						'pageSize'=>20,
				)

		));
	}

	public static function encrypt($value)
	{
		return md5($value);
	}

	/**
	 * perform one-way encryption on the password before we store it in
	 the database
	 */
	protected function afterValidate()
	{
		$this->UserPassword = self::encrypt($this->UserPassword);
		return parent::afterValidate();
	}

	public function getById($id) {
		return $this->findByPk($id);
	}
}