<?php
class Gallery extends Article
{
	public $GalleryId;
	public $GalleryOrder;

	public function getById($id) {
		$sql = "
SELECT
	GalleryId,
	ArticleId,
	GalleryOrder
FROM
	galleries
WHERE
	GalleryId = :id
";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
		if ($node === false) {
			return false;
		}
		$this->GalleryId = $node['GalleryId'];
		$this->GalleryOrder = $node['GalleryOrder'];
		return parent::getById($node['ArticleId']);
	}

	public static function search($pageSize = 5) {
		$sql = "
select
  count(*)
from
  articles a inner join galleries g on a.ArticleId=g.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
";
		$command= Yii::app()->db->createCommand($sql);
		$command->bindParam(":langId",Yii::app()->language);
		$count=$command->queryScalar();

		$sql = "
select
  g.GalleryId, g.ArticleId, g.GalleryOrder
from
  articles a inner join galleries g on a.ArticleId=g.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'GalleryId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'GalleryOrder' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'GalleryOrder',
						),
				),
				'pagination'=>array(
						'pageSize'=>$pageSize,
				),
				'params'=>array(
						':langId'=>Yii::app()->language,
				), //needed if $id is not null
		));
		$dataProvider->setId('GalleryId');
		return $dataProvider;
	}


	public function getTitle() {
		if ($this->scenario=='' || $this->scenario=='index') {
			return Yii::t('core','Gallery');
		}
		return parent::getTitle();
	}

}