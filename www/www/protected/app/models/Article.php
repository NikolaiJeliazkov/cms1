<?php
class Article extends CmsModel
{
	const OPTIONS_SHOWAUTHOR=1;
	const OPTIONS_SHOWCREATETIME=2;
	const OPTIONS_SHOWMODIFIEDTIME=4;

	public $ArticleId;
	public $ArticleCreateTime;
	public $ArticleModifyTime;
	public $ArticleAuthor;
	public $ArticleActivated;
	public $ArticleOptions;
	public $ArticleValidFrom;
	public $ArticleValidTo;
	public $ArticleTitle;
	public $ArticleSubtitle;
	public $ArticleContent;
	public $ArticleTags;
	public $ArticleMetaKeywords;
	public $ArticleMetaDescription;

	public function attributeLabels()
	{
		return array_merge(
			parent::attributeLabels(),
			array(
				'ArticleId' => '#',
				'ArticleCreateTime' => 'Дата на създаване',
				'ArticleModifyTime' => 'Дата на последна промяна',
				'ArticleAuthor' => 'Автор',
				'ArticleActivated' => 'Активна',
				'ArticleOptions' => 'Options',
				'ArticleValidFrom' => 'Валидна след',
				'ArticleValidTo' => 'Валидна до',
				'ArticleTitle' => 'Заглавие',
				'ArticleSubtitle' => 'Подзаглавие',
				'ArticleContent' => 'Текст',
				'ArticleTags' => 'Ключови думи',
				'ArticleMetaKeywords' => 'MetaKeywords',
				'ArticleMetaDescription' => 'MetaDescription',
			)
		);
	}

	public function getById($id) {
		$sql = "
SELECT
	ArticleId,
	LangId,
	ArticleCreateTime,
	ArticleModifyTime,
	ArticleAuthor,
	ArticleActivated,
	ArticleOptions,
	ArticleValidFrom,
	ArticleValidTo,
	ArticleTitle,
	ArticleSubtitle,
	ArticleContent,
	ArticleTags,
	ArticleMetaKeywords,
	ArticleMetaDescription
FROM
	articles
WHERE
	ArticleId = :ArticleId
";
		$a = explode('|',$id);
		$id = $a[0];
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':ArticleId'=>$id));
		if ($node === false) {
			return false;
		}
		$this->ArticleId = $node['ArticleId'];
		$this->ArticleCreateTime = $node['ArticleCreateTime'];
		$this->ArticleModifyTime = $node['ArticleModifyTime'];
		$this->ArticleAuthor = $node['ArticleAuthor'];
		$this->ArticleActivated = $node['ArticleActivated'];
		$this->ArticleOptions = $node['ArticleOptions'];
		$this->ArticleValidFrom = $node['ArticleValidFrom'];
		$this->ArticleValidTo = $node['ArticleValidTo'];
		$this->ArticleTitle = $node['ArticleTitle'];
		$this->ArticleSubtitle = $node['ArticleSubtitle'];
		$this->ArticleContent = $node['ArticleContent'];
		$this->ArticleTags = $node['ArticleTags'];
		$this->ArticleMetaKeywords = $node['ArticleMetaKeywords'];
		$this->ArticleMetaDescription = $node['ArticleMetaDescription'];
		return true;
	}

	public function getTitle() {
		return $this->ArticleTitle;
	}

	public function getUserName() {
		$u = CmsModel::model('User',$this->ArticleAuthor);
		return $u->UserName;
	}
}