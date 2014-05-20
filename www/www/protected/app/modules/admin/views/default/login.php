<?php
$this->pageTitle=Yii::app()->name . ' - Вход';
$this->breadcrumbs=array(
// 	'Вход',
);
?>
<fieldset>
	<legend>Вход</legend>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'well'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'UserEmail', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'UserPassword', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Вход', 'icon'=>'ok')); ?>
</div>
<?php $this->endWidget(); ?>
</fieldset>