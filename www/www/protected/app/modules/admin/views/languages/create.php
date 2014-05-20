<?php
$this->breadcrumbs=array(
	'Езици'=>array('index'),
	'Нов',
);
?>
<fieldset>
	<legend>Нов език</legend>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>