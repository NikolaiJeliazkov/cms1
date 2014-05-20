<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
// 		'htmlOptions'=>array('class'=>'well'),
		'id'=>'articles-form',
// 		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
		'inlineErrors'=>true,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
// echo $form->errorSummary($model);
?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span8 well">
			<?php echo $form->textFieldRow($article, 'ArticleTitle', array('class'=>'span12')); ?>
			<br />
			<?php echo $form->textFieldRow($article, 'ArticleSubtitle', array('class'=>'span12')); ?>
			<br />
			<?php echo $form->textAreaRow($model, 'EventShortContent', array('class'=>'span12', 'rows'=>3)); ?>
			<br />
			<?php echo $form->redactorRow($article, 'ArticleContent', array('rows'=>5, 'height'=>'200px',
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

			<div class="form-actions">
				<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->isNewRecord?'Създай':'Запази'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>
				&nbsp;
				<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
			</div>
		</div>
		<div class="span4 well">
			<fieldset>
				<legend>Публикуване</legend>
				<?php echo $form->toggleButtonRow($article, 'ArticleActivated'); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleTags', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaKeywords', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->textFieldRow($article, 'ArticleMetaDescription', array('class'=>'span12')); ?>
				<br />
				<?php echo $form->datepickerRow($model, 'EventStartDate', array('prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))).'<br />'; ?>
				<?php echo $form->datepickerRow($model, 'EventEndDate', array('prepend'=>'<i class="icon-calendar"></i>', 'options'=>array('format'=>'yyyy-mm-dd'))).'<br />'; ?>
				<?php //echo $form->checkBoxListRow($article, 'ArticleOptions', $article->statesData); ?>
			</fieldset>
		</div>
		<div class="span4 well">
			<fieldset>
				<legend>Картинка</legend>
				<?php echo $form->fileFieldRow($model, 'image'); ?><br/>
				<?php if (realpath('./images/calendar/thumbs/'.$model->EventId.'.png')) echo CHtml::image('/images/calendar/thumbs/'.$model->EventId.'.png'); ?>
				</fieldset>
		</div>

	</div>
</div>
<?php $this->endWidget(); ?>
