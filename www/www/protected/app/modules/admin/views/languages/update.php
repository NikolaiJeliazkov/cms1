<?php
$this->breadcrumbs=array(
	'Езици'=>array('index'),
	$model->LangName=>array('view','id'=>$model->LangId),
	'Промяна',
);

$this->menu=array(
	array('label'=>'Действия','visible'=>true),
	array(
		'label'=>'Виж',
		'icon'=>'eye-open',
		'url'=>array('view', 'id'=>$model->LangId),
	),
	array(
		'label'=>'Изтрий',
		'icon'=>'minus',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->LangId),
			'confirm'=>'Потвърдете изтриването!'
		),
	),
);

if (Yii::app()->language!=$model->LangId) {
	$this->menu[] = array(
			'label'=>'Превключи',
			'icon'=>'check',
			'url'=>array('switch', 'id'=>$model->LangId),
	);
}

?>

<fieldset>

	<legend><?php echo $model->LangName; ?></legend>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>