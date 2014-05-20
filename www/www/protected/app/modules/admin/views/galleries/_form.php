<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
// 		'htmlOptions'=>array('class'=>'well'),
		'id'=>'galleries-form',
		// 	'type'=>'horizontal',
		'enableAjaxValidation'=>false,
		'inlineErrors'=>true,
//		'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
$images = Images::model();
$images->GalleryId = $model->GalleryId;

echo $form->errorSummary($model);
echo $form->errorSummary($images);
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span8 well">
			<?php echo $form->textFieldRow($article, 'ArticleTitle', array('class'=>'span12')); ?>
			<div class="form-actions">
				<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->isNewRecord?'Създай':'Запази'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>
				&nbsp;
				<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
			</div>
<?php

if (!$model->isNewRecord) {

// the button that may open the dialog
$this->widget('zii.widgets.jui.CJuiButton', array(
		'name'=>'btndialog',
		'caption'=>'Нова картинка',
		'onclick'=>new CJavaScriptExpression('function(){$("#mydialog").dialog("open"); return false;}'),
));

$gridDataProvider = $images->search();

// Yii::trace(CVarDumper::dumpAsString($gridDataProvider->getData()),'vardump');

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
		'filter'=>$person,
		'type'=>'striped bordered',
		'dataProvider' => $gridDataProvider,
		'template' => "{items}",
		'sortableRows'=>true,
		'sortableAttribute' => 'ImageOrder',
		'sortableAjaxSave' => true,
		'sortableAction' => Yii::app()->createUrl("/admin/galleries/imagesReorder"),
		'hideHeader' => true,
		'columns' => array(
				array(
						'class'=>'bootstrap.widgets.TbImageColumn',
						'imagePathExpression' => '$data[\'ImagePath\'].\'/\'.$data[\'GalleryId\'].\'/tmb/\'.$data[\'ImageBaseName\']',
				),
				array(
						'name' => 'ImageDescription',
						'class' => 'bootstrap.widgets.TbEditableColumn',
						'editable' => array(
								'type' => 'textarea',
								'url' => Yii::app()->createUrl("/admin/galleries/imageUpdate"),
						)
				),
				array(
						'class'=>'bootstrap.widgets.TbButtonColumn',
						'template'=>'{delete}',
						'deleteButtonUrl' => 'Yii::app()->createUrl("/admin/galleries/imageDelete", array("id" => $data[\'ImageId\']))',
						'htmlOptions'=>array('style'=>'width: 25px'),
				),

		)));
}
?>


		</div>
		<div class="span4 well">
			<fieldset>
				<legend>Публикуване</legend>
				<?php echo $form->toggleButtonRow($article, 'ArticleActivated'); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaKeywords', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaDescription', array('class'=>'span12')); ?>
			</fieldset>
		</div>

	</div>
</div>
<?php $this->endWidget(); ?>
<?php
if (!$model->isNewRecord) {

	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
			'id'=>'mydialog',
			// additional javascript options for the dialog plugin
			'options'=>array(
					'title'=>'Нова картинка',
					'autoOpen'=>false,
// 					'height'=>250,
					'width'=>500,
					'buttons' => array(
							array('text'=>'Зареди','click'=> 'js:function(){$("#images-form").submit();}'),
							array('text'=>'Откажи','click'=> 'js:function(){$(this).dialog("close");}'),
					),
			),
	));
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	// 		'htmlOptions'=>array('class'=>'well'),
			'id'=>'images-form',
			// 	'type'=>'horizontal',
			'enableAjaxValidation'=>false,
			'inlineErrors'=>true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));
	echo $form->textFieldRow($images, 'ImageDescription',array('class'=>'span6'));
	echo $form->fileFieldRow($images, 'image');
	$this->endWidget();



	$this->endWidget('zii.widgets.jui.CJuiDialog');

}
?>