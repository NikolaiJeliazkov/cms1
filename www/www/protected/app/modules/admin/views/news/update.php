<?php
$this->breadcrumbs=array(
	'Новини'=>array('index'),
	$model->article->ArticleTitle,
);

?>

<fieldset>

	<legend><?php echo $model->article->ArticleTitle; ?></legend>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>

</fieldset>