<?php
$this->breadcrumbs=array(
	Yii::t('core', 'News')=>Yii::app()->urlManager->createUrl('news'),
	$m->getTitle(),
);
$this->pageTitle=$m->getTitle();

?>
<div class="post">
	<h2 class="title <?php if ($m->ArticleActivated==1) echo 'postDraft'; ?>"><?php echo CHtml::encode($m->getTitle()); ?></h2>
<?php if($m->ArticleSubtitle!=''):?>
	<h3><?php echo CHtml::encode($m->ArticleSubtitle); ?></h3>
<?php endif?>
<?php if (($m->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) || ($m->ArticleOptions & Article::OPTIONS_SHOWCREATETIME)) :?>
	<div class="meta clearfix">
	<?php if ($m->ArticleOptions & Article::OPTIONS_SHOWCREATETIME) :?>
		<span class="date"><?php echo CmsModel::getdate($m->PostPubDate,'d.m.Y'); ?></span>
	<?php endif ?>
	<?php if ($m->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) :?>
		<span class="author"><?php echo $m->getUserName(); ?></span>
	<?php endif ?>
	</div>
<?php endif ?>
	<div class="entry">
		<?php if (realpath('./images/news/thumbs/'.$m->PostId.'.png')) echo CHtml::image('/images/news/'.$m->PostId.'.png'); ?>
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $m->ArticleContent;
			$this->endWidget();
		?>
		<div style="clear: both;">&nbsp;</div>
		<p class="links">
			<?php if ($m->ArticleOptions & Article::OPTIONS_SHOWMODIFIEDTIME) :?>
			<?php echo Yii::t('core', 'ArticleModifyTime') . ' ' . CmsModel::getdate($m->ArticleModifyTime); ?>
			<?php endif ?>
			<?php if (trim($m->ArticleTags) != '') : ?>
				<?php if ($m->ArticleOptions & Article::OPTIONS_SHOWMODIFIEDTIME) :?>
					&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endif ?>
				<?php echo Yii::t('core', 'ArticleTags').':&nbsp;'.implode(', ', array($m->ArticleTags)); ?>
			<?php endif ?>
		</p>
	</div>
</div>