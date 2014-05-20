<?php
class Calendar extends Article
{

	public $EventId;
	public $EventStartDate;
	public $EventEndDate;
	public $EventShortContent;

	public function attributeLabels()
	{
		return array_merge(
				parent::attributeLabels(),
				array(
						'EventId' => 'EventId',
						'EventStartDate' => 'Начало',
						'EventEndDate' => 'Край',
						'EventShortContent' => 'Кратък текст',
				)
		);
	}

	public function getById($id) {
		$sql = "
SELECT
	EventId,
	ArticleId,
	EventStartDate,
	EventEndDate,
	EventShortContent
FROM
	events
WHERE
	EventId = :id
";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
		if ($node === false) {
			return false;
		}
		$this->EventId = $node['EventId'];
		$this->EventStartDate = $node['EventStartDate'];
		$this->EventEndDate = $node['EventEndDate'];
		$this->EventShortContent = $node['EventShortContent'];
		return parent::getById($node['ArticleId']);
	}

	public function getAnonceText($l = 900) {
		if ($this->EventShortContent != '') {
			return $this->EventShortContent;
		}
		$s = $this->ArticleContent;
		$s = preg_replace('/<p>(.*)<\/p>/i',"\\1\n",$s);
		$s = preg_replace('/<[a-z\/][^>]*>/i','',$s);
		$s = (strlen($s)>$l)?substr($s,0,strpos($s,' ',$l)+1)."...":$s;
		$s = str_replace(array("\r\n", "\n\n", "\r"),"\n",$s);
		$s = strip_tags($s);
		return $s;
	}

	public static function search($pageSize=5, $startDate=false) {
		if ($startDate===false) {
			$startDate = date('Y-m-d');
		}
		$sql = "
select
  count(*)
from
  articles a inner join events e on a.ArticleId=e.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
";
		$command= Yii::app()->db->createCommand($sql);
		$command->bindParam(":langId",Yii::app()->language);
		$count=$command->queryScalar();

		$pagination = new CPagination();
		$pagination->pageSize = $pageSize;
		$sql = "
select
  count(*)
from
  articles a inner join events e on a.ArticleId=e.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
  and :startDate < e.EventStartDate
";
		$command= Yii::app()->db->createCommand($sql);
		$command->bindParam(":langId",Yii::app()->language);
		$command->bindParam(":startDate",$startDate);
		$cMin=$command->queryScalar();
		$currentPage = floor($cMin/$pageSize);
		if(!Yii::app()->request->isAjaxRequest) {
			$pagination->currentPage=$currentPage;
		}
		$sql = "
select
  e.EventId, e.ArticleId, e.EventStartDate, EventEndDate, e.EventShortContent
from
  articles a inner join events e on a.ArticleId=e.ArticleId
where
  a.LangId=:langId
  and coalesce(a.ArticleActivated,0)<>0
  and now() between coalesce(a.ArticleValidFrom,now()) and coalesce(a.ArticleValidTo,now())
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'EventId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'EventStartDate' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'EventStartDate',
						),
				),
				'pagination'=>$pagination,
				'params'=>array(
						':langId'=>Yii::app()->language,
				),
		));
		$dataProvider->setId('EventId');
		return $dataProvider;
	}

	public function getTitle() {
		if ($this->scenario=='' || $this->scenario=='index') {
			return Yii::t('core','Calendar');
		}
		return parent::getTitle();
	}






}