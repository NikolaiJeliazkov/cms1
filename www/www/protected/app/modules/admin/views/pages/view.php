<?php
$this->breadcrumbs=SiteMap::getBreadcrumbs($model->id);
// $this->menu=array(
// 	array('label'=>'Действия','visible'=>true),
// 	array(
// 		'label'=>'Промени',
// 		'icon'=>'pencil',
// 		'url'=>array('update', 'id'=>$model->id),
// 	),
// 	array(
// 		'label'=>'Изтрий',
// 		'icon'=>'minus',
// 		'url'=>'#',
// 		'linkOptions'=>array(
// 			'submit'=>array('delete','id'=>$model->id),
// 			'confirm'=>'Потвърдете изтриването!'
// 		),
// 	),
// );

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
// 		'htmlOptions'=>array('class'=>'well'),
		'id'=>'articles-form',
		// 		'type'=>'horizontal',
// 		'enableAjaxValidation'=>true,
		'inlineErrors'=>true,
));

?>
<?php
echo $form->errorSummary($model);
echo $form->errorSummary($article);
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span8 well">
			<fieldset>
				<legend>Страница</legend>

				<?php echo $form->textFieldRow($article, 'ArticleTitle', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleSubtitle', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->redactorRow($article, 'ArticleContent', array('rows'=>5,
						'options' => array(
								'lang' => 'bg',
								//'toolbar' => false,
								'iframe' => true,
								'css'=>Yii::app()->theme->baseUrl.'/inc/css/main.css',
								'cleanup' => true,
								'imageUpload' => Yii::app()->createUrl('admin/images/upload'),
								'imageGetJson' => Yii::app()->createUrl('admin/images/index'),
						),
				)); ?>
			</fieldset>


			<div class="form-actions">
				<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->id ?'Запази':'Създай'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>
				&nbsp;
				<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
			</div>

		</div>
		<div class="span4 well">
			<fieldset>
				<legend>Публикуване</legend>
				<?php echo $form->textFieldRow($model, 'url', array('class'=>'span6', 'prepend'=>SiteMap::getPath($model->parent).'/', 'disabled'=>($model->parent==''))); ?>
				<br />
				<?php echo $form->toggleButtonRow($article, 'ArticleActivated'); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleTags', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaKeywords', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaDescription', array('class'=>'span12')); ?>
				<br />
<?php //echo $form->datepickerRow($article, 'ArticleValidFrom', array('prepend'=>'<i class="icon-calendar"></i>')).'<br />'; ?>
<?php //echo $form->datepickerRow($article, 'ArticleValidTo', array('prepend'=>'<i class="icon-calendar"></i>')).'<br />'; ?>
<?php
// $sm = SiteMap::model();
// $sm->parent = $model->id;
// $dataProvider = $sm->search();
// $dataProvider->keyAttribute = 'id';

// TODO: Да се оправи преподреждането на подстраниците
// Смятам, че ако се използва ActiveRecord ще се оправи

$dataProvider=new CArrayDataProvider(SiteMap::getChildren($model->id,false,true), array(
		'keyField'=>'id',
		'sort'=>false,
		'pagination'=>false,
));
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'childs-grid',
	'type'=>'condensed',
	'sortableRows'=>true,
	'sortableAttribute' => 'id',
	'sortableAjaxSave' => true,
	'sortableAction' => Yii::app()->createUrl("/admin/pages/reorder",array("id"=>$model->id)),
// 	'afterSortableUpdate' => 'js:function(sortKeyValue){ console.log(sortKeyValue);}',
// 	'afterSortableUpdate'   => 'js:function(sortKeyValue){ $.ajax({type:"POST", url: "'.Yii::app()->createUrl("/admin/pages/reorder",array("id"=>$model->id)).'", data: sortKeyValue}); }',
// 	'afterSortableUpdate' => 'js:function(id, pos){ console.log(id); console.log(pos);}',
// 	'afterSortableUpdate' => 'js:function(id, position){ window.location.reload(); return true;}',
	'type'=>'striped bordered',
	'dataProvider' => $dataProvider,
	'template' => "{items}\n".CHtml::link("Добави страница",Yii::app()->createUrl("/admin/pages/create",array("parent"=>$model->id))),
	'columns'=>array(
// 			'id',
// 			'pos',
			array(
					'class'=>'CLinkColumn',
					'labelExpression'=>'$data[label]',
					'urlExpression'=>'Yii::app()->createUrl("/admin/pages/view",array("id"=>$data[id]))',
					'header'=>'Подстраници'
			),
			array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{delete}',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/admin/pages/delete",array("id"=>$data[id]))',
// 					'htmlOptions'=>array('style'=>'width: 100px'),
			),
	),
));
?>
			</fieldset>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
//$("#Articles_ArticleValidFrom").datepicker({
//	format: 'yyyy-mm-dd'
//});
//$("#Articles_ArticleValidTo").datepicker({
//	format: 'yyyy-mm-dd'
//});
</script>

