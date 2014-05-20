<?php
/**
 * @version $Id: column2.php 458 2012-06-21 14:06:14Z njeliazkov $
 */
?>
<?php $this->beginContent('/layouts/main'); ?>
<div class="container-fluid">
	<div class="row-fluid">
	<div class="span10">
		<?php echo $content; ?>
	</div>
<?php if(isset($this->menu) && count($this->menu)>0):?>
<div class="span2">
<?php $this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'list',
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'well'),
)); ?>
</div>
<?php endif?>
	</div>
</div>

<?php $this->endContent(); ?>



