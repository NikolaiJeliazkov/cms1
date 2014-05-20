<?php

$this->breadcrumbs=array(
		'Галерии'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Добави галерия',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<fieldset>
	<legend>Галерии</legend>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'galleries-grid',
	'sortableRows'=>true,
	'sortableAttribute' => 'GalleryOrder',
	'sortableAjaxSave' => true,
	'sortableAction' => Yii::app()->createUrl("/admin/galleries/reorder"),
// 	'afterSortableUpdate' => 'js:function(sortOrder){ document.location.reload(); console.log(sortOrder);}',

	'dataProvider'=>$dataProvider,
	'columns'=>array(
// 		'GalleryId',
// 		'GalleryOrder',
		'article.ArticleTitle',
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{update} {delete}',
				'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
)); ?>
</fieldset>