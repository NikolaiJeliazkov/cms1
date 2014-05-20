<?php
$a = $m->getData();
$this->pageTitle = $a->ArticleTitle . (($a->ArticleSubtitle!='')?' - '.$a->ArticleSubtitle:'');
$this->metaKeywords = $a->ArticleMetaKeywords;
$this->metaDescription = $a->ArticleMetaDescription;
// $this->breadcrumbs=$m->breadcrumbs;

echo $a->ArticleContent;

$this->widget(
	'ext.widgets.LastNewsWidget',
	array(
		'id'=>'indexNews',
		'itemsCount'=>2,
	)
);
