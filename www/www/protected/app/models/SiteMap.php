<?php
/**
 * This is the model class for table "sitemap".
 *
 * The followings are the available columns in table 'sitemap':
 * @property string $id
 * @property string $parent
 * @property string $LangId
 * @property string $url
 * @property string $pos
 * @property string $ModuleName
 * @property string $ModuleData
 *
 * The followings are the available model relations:
 * @property Languages $lang
 * @property Modules $moduleName
 * @property SiteMap $parent0
 * @property SiteMap[] $sitemaps
 */

class SiteMap  extends CActiveRecord
{
// 	protected $_ArticleId;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SiteMap the static model class
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
		return 'sitemap';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('LangId, url, pos, ModuleName', 'required'),
				array('parent, pos', 'length', 'max'=>10),
				array('LangId', 'length', 'max'=>2),
				array('url, ModuleName', 'length', 'max'=>255),
				array('ModuleData', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, parent, LangId, url, pos, ModuleName, ModuleData', 'safe', 'on'=>'search'),
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
				'lang' => array(self::BELONGS_TO, 'Languages', 'LangId'),
				'moduleName' => array(self::BELONGS_TO, 'Modules', 'ModuleName'),
				'parent0' => array(self::BELONGS_TO, 'SiteMap', 'parent'),
				'sitemaps' => array(self::HAS_MANY, 'SiteMap', 'parent'),
// 				'moduleData' => array(self::BELONGS_TO, 'Articles', 'ArticleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'parent' => 'Parent',
				'LangId' => 'Lang',
				'url' => 'Url',
				'pos' => 'Pos',
				'ModuleName' => 'Module Name',
				'ModuleData' => 'Module Data',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('LangId',Yii::app()->language,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('pos',$this->pos,true);
		$criteria->compare('ModuleName',$this->ModuleName,true);
		$criteria->compare('ModuleData',$this->ModuleData,true);
		$criteria->order = 'pos';

// 		Yii::trace(CVarDumper::dumpAsString($criteria),'vardump');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
				'sort'=>false,
		));
	}
	public static function getPath($id) {
		$path = array();
// 		$mName = 'site';
		$sql = "select id,parent,url,LangId,ModuleName from sitemap where id=:id";
		do {
			$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
			if ($node['parent']) {
				array_push($path, $node['url']);
				$id = $node['parent'];
				$mName = $node['ModuleName'];
			} else break;
		} while (1==1);
		$path = array_reverse($path);
// 		Yii::trace(CVarDumper::dumpAsString($path),'vardump');
		$path = Yii::app()->urlManager->createUrl($mName.'/'.implode("/", $path));
		return $path;
	}

	public static function createNew(
			$parent,
			$LangId=false,
			$url=false,
			Articles $article=null,
			$ModuleName='site',
			$ModuleData=null
	) {
		$rand = rand();
		$parentNode=SiteMap::model()->findByPk($parent);
		if ($LangId===false)
			$LangId = Yii::app()->language;
		if ($url===false)
			$url = 'new_'.$rand;
		if ($ArticleTitle===false)
			$ArticleTitle = Yii::t('core', 'New page').' '.$rand;
		if ($ArticleAuthor===false)
			$ArticleAuthor = Yii::app()->user->id;
		if (!is_null($parentNode)) {
			$LangId = $parentNode->LangId;
		}
		try {
			$transaction=Yii::app()->db->beginTransaction();
			$model = new SiteMap;
			$model->parent = $parent;
			$model->LangId = $LangId;
			$model->url = $url;
			$sql = "SELECT COALESCE(MAX(pos+1),0) FROM sitemap WHERE parent=:parent";
			$model->pos =Yii::app()->db->createCommand($sql)->queryScalar(array(':parent'=>$parent));
			$model->ModuleName = $ModuleName;

			if (!is_null($article))
				$model->ModuleData = $article->ArticleId;
			$model->save(false);
// 			Yii::trace(CVarDumper::dumpAsString($model->id),'vardump');

			$transaction->commit();
		}
		catch(Exception $e)
		{
			$transaction->rollback();
			return false;
		}
		Yii::trace(CVarDumper::dumpAsString($model->attributes),'vardump');
		return $model;
	}

	public static function getBreadcrumbs($id) {
		$path = array();
// 		$sql = "select id,parent,url,LangId,ModuleName from sitemap where id=:id";
		$sql = "
select
  s.id,
  s.parent,
  s.LangId,
  s.url,
  s.pos,
  s.ModuleName,
  s.ModuleData,
  m.ModuleClass
from sitemap s, modules m
where s.ModuleName=m.ModuleName and s.id=:id
order by s.pos asc";
		do {
			$command = Yii::app()->db->createCommand($sql);
			$node=$command->queryRow(true,array(':id'=>$id));
// 			Yii::trace(CVarDumper::dumpAsString($node),'vardump');
			if ($node['parent']) {
				$m = CmsModel::model($node['ModuleClass'], $node['ModuleData']);
				$path[$m->getTitle()] = array('view','id'=>$id);
				$id = $node['parent'];
			} else break;
		} while (1==1);
		$path = array_reverse($path);
// 		Yii::trace(CVarDumper::dumpAsString($path),'vardump');
// 		$path = Yii::app()->urlManager->createUrl($mName.'/'.implode("/", $path));
		return $path;
	}

	public static function getChildren($parent, $recursive=true, $adminMode=false) {
// 		$path = self::getPath($parent);
		$sql = "
select
  s.id,
  s.parent,
  s.LangId,
  s.url,
  s.pos,
  s.ModuleName,
  s.ModuleData,
  m.ModuleClass
from sitemap s, modules m
  where s.ModuleName=m.ModuleName and s.parent=:parent and LangId=:LangId
order by pos asc";
		$nodes=Yii::app()->db->createCommand($sql)->queryAll(true,array(':parent'=>$parent, 'LangId'=>Yii::app()->language));
		$result = array();
		foreach ($nodes as $node) {
			$m = CmsModel::model($node['ModuleClass'], $node['ModuleData']);
			if (!$adminMode && get_class($m)=='Article' && $m->ArticleActivated==0) {
				continue;
			}
// 			Yii::trace(CVarDumper::dumpAsString(get_class($m)),'vardump');
			if ($recursive) {
				$items = self::getChildren($node['id'],(is_int($recursive))?$recursive-1:$recursive);
				if (count($items)) {
					$result[] = array('label'=>$m->getTitle(), 'url'=>self::getPath($node['id']), 'id'=>$node['id'], 'pos'=>$node['pos'], 'items'=>$items);
				} else {
					$result[] = array('label'=>$m->getTitle(), 'url'=>self::getPath($node['id']), 'id'=>$node['id'], 'pos'=>$node['pos']);
				}
			} else {
				$result[] = array('label'=>$m->getTitle(), 'url'=>self::getPath($node['id']), 'id'=>$node['id'], 'pos'=>$node['pos']);
			}
		}
		return $result;
	}

	public static function getRoot() {
		$sql = "select id from sitemap where parent is null and pos=0 and LangId=:LangId
order by pos asc";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array('LangId'=>Yii::app()->language));
		if (false !== $node) {
			return $node['id'];
		}
		return false;
	}

	public static function create($url)
	{
		$path = explode('/', trim($url,'/'));
		$lang = Yii::app()->language;

		$breadcrumbs = array();
		$curentPath = array();
		array_push($curentPath, $lang);

		$sql = "
select
  s.id,
  s.parent,
  s.LangId,
  s.url,
  s.pos,
  s.ModuleName,
  s.ModuleData,
  m.ModuleClass
from sitemap s, modules m
  where s.ModuleName=m.ModuleName and s.LangId=:LangId and parent is null
order by pos asc";
		$index=Yii::app()->db->createCommand($sql)->queryRow(true,array(':LangId'=>Yii::app()->language));
		$node = $index;
		if (count($path) == 0)
		{
			$m = new SitemapNode();
			$m->setAttributes($node,false);
		}
		else
		{
			$parent = $index['id'];
			while (1==1)
			{
				$url = array_shift($path);
				$sql = "
select
  s.id,
  s.parent,
  s.LangId,
  s.url,
  s.pos,
  s.ModuleName,
  s.ModuleData,
  m.ModuleClass
from sitemap s, modules m
  where s.ModuleName=m.ModuleName and s.LangId=:LangId and parent=:parent and url=:url
order by pos asc";
				$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':LangId'=>Yii::app()->language, ':parent'=>$parent, ':url'=>$url));
				if ($node === false) {
					throw new CHttpException(404,Yii::t('core','alabala "{action}".',array('{action}'=>$url)));
				}
				$parent = $node['id'];
// 				$m = new $node['ModuleClass']($node['id'], $node['ModuleData'], $path);
				$m = new SitemapNode();
				$m->setAttributes($node,false);
				array_push($curentPath, $url);
				$a = $m->getData();
				if (empty($path)) {
					$breadcrumbs[] = $a->ArticleTitle;
					break;
				}
				$breadcrumbs[$a->ArticleTitle] = SiteMap::getPath($node['id']);
			}
		}
		$m->breadcrumbs = $breadcrumbs;
		return $m;
	}

// 	protected function beforeDelete()
// 	{
// 		$this->_ArticleId = $this->ModuleData;
// 		Articles::model()->deleteAll('ArticleId = '.$this->ModuleData);
// 		return parent::beforeDelete();
// 	}

	protected function afterDelete()
	{
		Articles::model()->deleteAll('ArticleId = '.$this->ModuleData);
		return parent::afterDelete();
	}

}