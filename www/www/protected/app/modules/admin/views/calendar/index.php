<?php

$this->breadcrumbs=array(
		'Календар'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Добави събитие',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<fieldset>
	<legend>Календар</legend>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'calendar-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'EventId',
		'EventStartDate',
		'EventEndDate',
		'article.ArticleTitle',
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{update} {delete}',
				'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
)); ?>
</fieldset>