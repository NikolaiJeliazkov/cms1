<?php
/* @var $this LanguagesController */
/* @var $model Languages */

$this->breadcrumbs=array(
	'Езици'=>array('index'),
	$model->LangName,
);

$this->menu=array(
	array('label'=>'Действия','visible'=>true),
	array(
		'label'=>'Промени',
		'icon'=>'pencil',
		'url'=>array('update', 'id'=>$model->LangId),
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

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'LangId',
		'LangName',
		'LangActivated',
		'LangOrder',
	),
)); ?>

</fieldset>