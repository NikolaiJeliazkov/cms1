<?php
class SitemapNode extends CmsModel
{
	public $id;
	public $parent;
	public $LangId;
	public $url;
	public $pos;
	public $ModuleName;
	public $ModuleData;
	public $ModuleClass;
	public $ModuleDescription;

	public function attributeLabels()
	{
		return array_merge(
			parent::attributeLabels(),
			array(
				'id' => '#',
				'parent' => 'родител',
				'LangId' => 'език',
				'url' => 'url',
				'pos' => 'позиция',
				'ModuleName' => 'ModuleName',
				'ModuleData' => 'ModuleData',
				'ModuleClass' => 'ModuleClass',
				'ModuleDescription' => 'ModuleDescription',
			)
		);
	}

	public function getById($id) {
		$sql = "
select
  s.id,
  s.parent,
  s.LangId,
  s.url,
  s.pos,
  s.ModuleName,
  s.ModuleData,
  m.ModuleClass,
  m.ModuleDescription
from sitemap s, modules m
  where s.ModuleName=m.ModuleName and s.id=:id
order by pos asc
";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
		if ($node === false) {
			return false;
		}
		$this->id = $node['id'];
		$this->parent = $node['parent'];
		$this->LangId = $node['LangId'];
		$this->url = $node['url'];
		$this->pos = $node['pos'];
		$this->ModuleName = $node['ModuleName'];
		$this->ModuleData = $node['ModuleData'];
		$this->ModuleClass = $node['ModuleClass'];
		$this->ModuleDescription = $node['ModuleDescription'];
		return true;
	}

	public function getFirstChild() {
		$sql = "select * from sitemap where parent=:parent order by pos asc";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':parent'=>$this->id));
// 		print_r($node);
		return $node['url'];
	}

	public function getData() {
		$a = CmsModel::model($this->ModuleClass, $this->ModuleData, false, $this);
		return $a;
	}
}