<?php
$this->breadcrumbs=array($m->getTitle());
?>
<h2 class="title"><?php echo CHtml::encode($m->getTitle()); ?></h2>
<?php
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>Gallery::search(9),
		'itemView'=>'_view',
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