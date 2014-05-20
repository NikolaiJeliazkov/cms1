<?php
$this->breadcrumbs=array(
	Yii::t('core', 'Gallery')=>Yii::app()->urlManager->createUrl('gallery'),
	$m->getTitle(),
);
$this->pageTitle=$m->getTitle();

YiiUtil::registerCssAndJs('ext.fancyBox',
'/source/jquery.fancybox.pack.js',
'/source/jquery.fancybox.css');

?>
<div class="post">
	<h3 class="title"><?php echo CHtml::link(CHtml::encode($m->ArticleTitle), array('view', 'id'=>$m->GalleryId)); ?></h3>
<?php
$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
echo $m->ArticleContent;
$this->endWidget();
?>
	<div class="thumbs-wrapper clearfix">
<?php
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>GalleryImage::search($m->GalleryId),
		'itemView'=>'_imageItem',
		'template'=>"{items}",
		'cssFile'=>false,
));
?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("a[rel^='prettyPhoto']").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
});
</script>