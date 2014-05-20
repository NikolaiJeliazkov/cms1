<?php
$this->breadcrumbs=array(
		'Потребители'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Нов',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<fieldset>
	<legend>Потребители</legend>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'id'=>'users-grid',
		'type'=>'striped',
		'dataProvider'=>$model->search(),
		// 	'htmlOptions' => array('class' => 'grid-view rounded'),
		'columns'=>array(
		'UserId',
		'UserName',
		'UserEmail',
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'htmlOptions'=>array('style'=>'width: 100px'),
		),
	),
)); ?>
</fieldset>
