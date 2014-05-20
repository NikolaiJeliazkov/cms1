<?php
$this->breadcrumbs=array($m->getTitle());

$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>News::search(3),
		'itemView'=>'_view',
		// 		'template'=>"{items}",
		'template'=>"{items}\n{pager}",
		'cssFile'=>false,
		'pager'=>array(
				'class' => 'CLinkPager',
				'cssFile'=>false,
				'header'=>'',
				'prevPageLabel'=>'По-нови',
				'nextPageLabel'=>'По-стари',
				'maxButtonCount'=>'0',
		),
));
?>
<?php $this->widget('CLinkPager'); ?>