<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	$model->UserEmail,
);

$this->menu=array(
	array('label'=>'Действия','visible'=>true),
	array(
		'label'=>'Промени',
		'icon'=>'pencil',
		'url'=>array('update', 'id'=>$model->UserId),
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


<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'UserId',
		'UserName',
		'UserEmail',
		'UserActivated',
	),
)); ?>

</fieldset>

<form id="delete-form" method="post" action="<?php echo Yii::app()->urlManager->createUrl('admin/users/delete',array('id'=>$model->UserId))?>"></form>
<script>
function deleteUser() {
	if (confirm('Сигурни ли сте че искате да изтриете този елемент?')) {
		$("#delete-form").submit();
	}
}
</script>
