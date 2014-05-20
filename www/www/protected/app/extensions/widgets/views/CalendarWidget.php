<div id="<?php echo $this->id; ?>">
	<div class="title"><?php echo Yii::t('CalendarWidget','Calendar'); ?></div>
<?php
foreach($data as $n) {
	$a = CmsModel::model('Calendar',$n['EventId'],'preview');
?>
	<span class="date">
		<?php echo CmsModel::getdate($a->EventStartDate,'d.m.Y'); ?>
<?php if($a->EventEndDate!='') :?>
		 - <?php echo CmsModel::getdate($a->EventEndDate,'d.m.Y'); ?>
<?php endif;?>
	</span>
	<div><?php echo CHtml::link(CHtml::encode($a->ArticleTitle), array('calendar/view', 'id'=>$a->EventId)); ?></div>
<?php
}
?>
</div>