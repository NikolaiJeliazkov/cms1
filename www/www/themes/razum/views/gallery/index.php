<?php
$this->breadcrumbs=array($m->getTitle());
?>
<h2 class="title"><?php echo CHtml::encode($m->getTitle()); ?></h2>
<?php
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>Gallery::search(4),
		'itemView'=>'_view',
		'template'=>"{items}<br/>\n{pager}",
		'cssFile'=>false,
		'pager'=>array(
				'class' => 'CLinkPager',
				'cssFile'=>false,
				'header'=>'',
				'prevPageLabel'=>Yii::t('core', 'Backward'),
				'nextPageLabel'=>Yii::t('core', 'Forward'),
				'maxButtonCount'=>'0',
		),
));
?>
<?php $this->widget('CLinkPager'); ?>