<h2>Project List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New Project',array('create')); ?>]
[<?php echo CHtml::link('Manage Project',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?><?php foreach($projectList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('name')); ?>:
<?php echo CHtml::encode($model->name); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('path')); ?>:
<?php echo CHtml::encode($model->path); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('source_lang')); ?>:
<?php echo CHtml::encode($model->source_lang); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>