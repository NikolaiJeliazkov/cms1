<?php
$a = CmsModel::model('News',$data['PostId'],'preview');
?>
<div class="post">
	<h3 class="title"><?php echo CHtml::link(CHtml::encode($a->ArticleTitle), array('view', 'id'=>$a->PostId)); ?></h3>
<?php if (($a->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) || ($a->ArticleOptions & Article::OPTIONS_SHOWCREATETIME)) :?>
	<div class="meta clearfix">
	<?php if ($a->ArticleOptions & Article::OPTIONS_SHOWCREATETIME) :?>
		<span class="date"><?php echo CmsModel::getdate($a->PostPubDate,'d.m.Y'); ?></span>
	<?php endif ?>
	<?php if ($a->ArticleOptions & Article::OPTIONS_SHOWAUTHOR) :?>
		<span class="author"><?php echo $a->getUserName(); ?></span>
	<?php endif ?>
	</div>
<?php endif ?>
	<div class="entry clearfix">
		<?php if (realpath('./images/news/thumbs/'.$a->PostId.'.png')) echo CHtml::image('/images/news/thumbs/'.$a->PostId.'.png'); ?>
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $a->anonceText;
			$this->endWidget();
		?>
	</div>
</div>