<h2>View Project <?php echo $project->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Project List',array('list')); ?>]
[<?php echo CHtml::link('New Project',array('create')); ?>]
[<?php echo CHtml::link('Update Project',array('update','id'=>$project->id)); ?>]
[<?php echo CHtml::linkButton('Delete Project',array('submit'=>array('delete','id'=>$project->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage Project',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($project->getAttributeLabel('name')); ?>
</th>
    <td><?php echo CHtml::encode($project->name); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($project->getAttributeLabel('path')); ?>
</th>
    <td><?php echo CHtml::encode($project->path); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($project->getAttributeLabel('source_lang')); ?>
</th>
    <td><?php echo CHtml::encode($project->source_lang); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($project->getAttributeLabel('lang_list')); ?>
</th>
    <td><?php echo CHtml::encode($project->lang_list); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($project->getAttributeLabel('active')); ?>
</th>
    <td><?php echo CHtml::encode($project->active); ?>
</td>
</tr>
</table>
