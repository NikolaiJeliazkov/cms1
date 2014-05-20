<?php
class News extends Article
{
	public $PostId;
	public $PostPubDate;
	public $PostShortContent;

	public function attributeLabels()
	{
		return array_merge(
			parent::attributeLabels(),
			array(
				'PostId' => 'PostId',
				'PostPubDate' => 'Дата на публикуване',
				'PostShortContent' => 'Кратък текст',
			)
		);
	}

	public function getById($id) {
		$sql = "
SELECT
	PostId,
	PostPubDate,
	ArticleId,
	PostShortContent
FROM
	posts
WHERE
	PostId = :id
";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
		if ($node === false) {
			return false;
		}
		$this->PostId = $node['PostId'];
		$this->PostPubDate = $node['PostPubDate'];
		$this->PostShortContent = $node['PostShortContent'];
		return parent::getById($node['ArticleId']);
	}

	public function getAnonceText($l = 900) {
		if ($this->PostShortContent != '') {
			return $this->PostShortContent;
		}
		$s = $this->ArticleContent;
		$s = preg_replace('/<p>(.*)<\/p>/i',"\\1\n",$s);
		$s = preg_replace('/<[a-z\/][^>]*>/i','',$s);
		$s = (strlen($s)>$l)?substr($s,0,strpos($s,' ',$l)+1)."...":$s;
		$s = str_replace(array("\r\n", "\n\n", "\r"),"\n",$s);
		$s = strip_tags($s);
		return $s;
	}

	public static function search($pageSize = 5) {
		$sql = "
select
  count(*)
from
  articles a inner join posts p on a.ArticleId=p.ArticleId
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
  p.PostId, p.PostPubDate, p.ArticleId, p.PostShortContent
from
  articles a inner join posts p on a.ArticleId=p.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'PostId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'PostPubDate' => CSort::SORT_DESC,
// 								'PostId' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'PostPubDate',
						),
				),
				'pagination'=>array(
						'pageSize'=>$pageSize,
				),
				'params'=>array(
						':langId'=>Yii::app()->language,
				), //needed if $id is not null
		));
		$dataProvider->setId('PostId');
		return $dataProvider;
	}

	public function getTitle() {
		if ($this->scenario=='' || $this->scenario=='index') {
			return Yii::t('core','News');
		}
		return parent::getTitle();
	}

}