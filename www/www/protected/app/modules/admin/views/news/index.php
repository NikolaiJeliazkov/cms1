<?php
/* @var $this LanguagesController */
/* @var $model Languages */

$this->breadcrumbs=array(
		'Новини'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Добави новина',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<fieldset>
	<legend>
<?php
// $model = Posts::model()->with('article')->findByPk(1);
// $this->widget('editable.EditableField', array(
// 	'type'      => 'text',
// 	'model'     => $model,
// 	'attribute' => 'article.ArticleTitle',
// 	'url'       => $this->createUrl('site/updateUser'),
// 	'placement' => 'right',
// 	'inputclass'=>'input-large',
// ));
// echo "<br/>";
?>
	Новини</legend>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'languages-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'PostId',
		'PostPubDate',
// 		'article.ArticleCreateTime',
		'article.ArticleTitle',
		array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{update} {delete}',
				'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
)); ?>
</fieldset>