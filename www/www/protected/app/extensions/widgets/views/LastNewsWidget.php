<div id="<?php echo $this->id; ?>" class="clearfix">
	<div class="title"><?php echo Yii::t('LastNewsWidget','Last News');?></div>
<?php
foreach($data as $n) {
	$a = CmsModel::model('News',$n['PostId'],'preview');
?>
	<div class="post clearfix">
	<div class="title"><?php echo CHtml::link(CHtml::encode($a->ArticleTitle), array('news/view', 'id'=>$a->PostId)); ?></div>
	<span class="date"><?php echo CmsModel::getdate($a->PostPubDate,'d.m.Y'); ?></span>
		<div class="entry">
			<?php echo CHtml::image('/images/news/thumbs/'.$a->PostId.'.png'); ?>
			<?php
				$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
				echo $a->getAnonceText(300);
				$this->endWidget();
			?>
		</div>
	</div>
<?php
}

?>
</div>
<script>
$(function(){
	var a=0;
	$("#<?php echo $this->id; ?> > .post > .title").each(function(){
		if(a<$(this).outerHeight()){
			a = $(this).outerHeight();
		}
	})
	$("#<?php echo $this->id; ?> > .post > .title").outerHeight(a);
})
</script>