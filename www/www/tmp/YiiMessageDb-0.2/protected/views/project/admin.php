<h2>Managing Project</h2>

<div class="actionBar">
[<?php echo CHtml::link('Project List',array('list')); ?>]
[<?php echo CHtml::link('New Project',array('create')); ?>]
</div>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<table class="dataGrid">
  <tr>
    <th><?php echo $this->generateColumnHeader('id'); ?></th>
    <th><?php echo $this->generateColumnHeader('name'); ?></th>
    <th><?php echo $this->generateColumnHeader('path'); ?></th>
    <th><?php echo $this->generateColumnHeader('source_lang'); ?></th>
    <th><?php echo $this->generateColumnHeader('lang_list'); ?></th>
		<th><?php echo $this->generateColumnHeader('active'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($projectList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->name); ?></td>
    <td><?php echo CHtml::encode($model->path); ?></td>
    <td><?php echo CHtml::encode($model->source_lang); ?></td>
    <td><?php echo CHtml::encode($model->lang_list); ?></td>
    <?php
    if (CHtml::encode($model->active) == 1) {
      $img =Yii::app()->request->baseUrl."/images/active_on.png";
      $code_active ='<img src="'.$img.'" alt="active" />';
    }
    else {
      $img =Yii::app()->request->baseUrl."/images/active_off.png";
      $img_tag ='<img src="'.$img.'" alt="not active" />';
      $options =array("data"=>'id='.$model->id, "complete"=>'refreshColumnActive');
      $code_active =CHtml::ajaxLink($img_tag, array('setactive'), $options);
    }
    ?>
		<td class="img"><?php echo $code_active; ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>"Are you sure to delete #{$model->id}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").animate({opacity: 1.0}, 4000).slideUp("slow");',
   CClientScript::POS_READY
);
?>