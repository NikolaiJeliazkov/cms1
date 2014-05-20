<?php
/* @var $this LanguagesController */
/* @var $model Languages */

$this->breadcrumbs=array(
		'Езици'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Нов',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<fieldset>
	<legend>Езици</legend>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'languages-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'LangOrder',
		'LangId',
		'LangName',
		array(
				'class'=>'bootstrap.widgets.TbToggleColumn',
				'toggleAction'=>'toggle',
				'name' => 'LangActivated',
		),
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'htmlOptions'=>array('style'=>'width: 100px'),
		),
	),
)); ?>
</fieldset>