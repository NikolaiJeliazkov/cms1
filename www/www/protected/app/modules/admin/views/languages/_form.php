<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'languages-form',
// 	'type'=>'horizontal',
	'enableAjaxValidation'=>true,
	'inlineErrors'=>true,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'LangId', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'LangName', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'LangActivated', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'LangOrder', array('class'=>'span5')); ?><br/>
<div class="form-actions">
	<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->LangId ?'Запази':'Създай'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>&nbsp;
	<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
