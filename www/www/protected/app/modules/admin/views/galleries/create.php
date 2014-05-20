<?php
$this->breadcrumbs=array(
	'Галерии'=>array('index'),
	'Добавяне на галерия',
);
?>

<fieldset>

	<legend>Добавяне на галерия</legend>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>

</fieldset>