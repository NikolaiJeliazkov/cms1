<?php
$this->breadcrumbs=array(
	'Новини'=>array('index'),
	'Добавяне на новина',
);

?>
<fieldset>

	<legend>Добавяне на новина</legend>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>

</fieldset>
