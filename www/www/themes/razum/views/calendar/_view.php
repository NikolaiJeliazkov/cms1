<?php
$a = CmsModel::model('calendar',$data['EventId'],'preview');
?>
<div class="post">
	<h3 class="title"><?php echo CHtml::link(CHtml::encode($a->ArticleTitle), array('view', 'id'=>$a->EventId)); ?></h3>
<?php if (($a->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) || ($a->ArticleOptions & Article::OPTIONS_SHOWCREATETIME)) :?>
	<div class="meta clearfix">
	<?php if ($a->ArticleOptions & Article::OPTIONS_SHOWCREATETIME) :?>
		<span class="date">
			<?php echo CmsModel::getdate($a->EventStartDate,'d.m.Y'); ?>
			<?php if($a->EventEndDate!='') :?>
			 - <?php echo CmsModel::getdate($a->EventEndDate,'d.m.Y'); ?>
			<?php endif;?>
		</span>
	<?php endif ?>
	<?php if ($a->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) :?>
		<span class="author"><?php echo $a->getUserName(); ?></span>
	<?php endif ?>
	</div>
<?php endif ?>
	<div class="entry clearfix">
		<?php if (realpath('./images/calendar/thumbs/'.$a->EventId.'.png')) echo CHtml::image('/images/calendar/thumbs/'.$a->EventId.'.png'); ?>
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $a->anonceText;
			$this->endWidget();
		?>
	</div>
</div>