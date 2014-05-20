<h2>New Project</h2>

<div class="actionBar">
[<?php echo CHtml::link('Project List',array('list')); ?>]
[<?php echo CHtml::link('Manage Project',array('admin')); ?>]
</div>

<ul>
	<li><b>Path</b>: the path to your project root directory; where your main index.php is in.</li>
	<li><b>Source language / language list</b>: <a href="http://www.yiiframework.com/doc/guide/topics.i18n#locale-and-language">See here</a></li>
</ul>

<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($project); ?>

<div class="simple">
<?php echo CHtml::activeLabel($project,'name'); ?>
<?php echo CHtml::activeTextField($project,'name',array('size'=>60,'maxlength'=>128)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($project,'path'); ?>
<?php echo CHtml::activeTextField($project,'path',array('size'=>60,'maxlength'=>255)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($project,'source_lang'); ?>
<?php echo CHtml::activeTextField($project,'source_lang',array('size'=>5,'maxlength'=>5)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($project,'lang_list'). "(".Yii::t('project', "comma separed").")"; ?>
<?php echo CHtml::activeTextArea($project,'lang_list',array('rows'=>6, 'cols'=>60)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($project,'active'); ?>
<?php echo CHtml::activeCheckbox($project,'active'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton('Create'); ?>
</div>

</form>
</div><!-- yiiForm -->