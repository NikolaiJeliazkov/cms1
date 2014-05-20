<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'users-form',
// 	'type'=>'horizontal',
	'enableAjaxValidation'=>true,
	'inlineErrors'=>true,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'UserName', array('class'=>'span5')); ?><br/>
<?php echo $form->passwordFieldRow($model, 'UserPassword', array('class'=>'span5')); ?><br/>
<?php echo $form->passwordFieldRow($model, 'UserPassword_repeat', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'UserEmail', array('class'=>'span5')); ?><br/>
<?php echo $form->toggleButtonRow($model, 'UserActivated'); ?><br/>
<div class="form-actions">
	<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->UserId ?'Запази':'Създай'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>&nbsp;
	<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
