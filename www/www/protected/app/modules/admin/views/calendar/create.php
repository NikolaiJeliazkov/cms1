<?php
$this->breadcrumbs=array(
	'Календар'=>array('index'),
	'Добавяне на събитие',
);

?>
<fieldset>

	<legend>Добавяне на събитие</legend>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>

</fieldset>
