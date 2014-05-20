<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	'Нов',
);
?>
<fieldset>
	<legend>Нов потебител</legend>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>
