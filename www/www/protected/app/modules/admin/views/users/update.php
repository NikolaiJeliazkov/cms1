<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	$model->UserEmail=>array('view','id'=>$model->UserId),
	'Промяна',
);

$this->menu=array(
	array('label'=>'Действия','visible'=>true),
	array(
		'label'=>'Виж',
		'icon'=>'eye-open',
		'url'=>array('view', 'id'=>$model->UserId),
	),
	array(
		'label'=>'Изтрий',
		'icon'=>'minus',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->UserId),
			'confirm'=>'Потвърдете изтриването!'
		),
	),
);
?>
<fieldset>

	<legend>Профил <i>(<?php echo $model->UserEmail; ?>)</i></legend>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>
