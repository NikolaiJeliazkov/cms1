<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo Yii::app()->language; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="<?php echo Yii::app()->language; ?>" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php if($this->metaKeywords!=''):?>
<meta name="keywords" content="<?php echo CHtml::encode($this->metaKeywords); ?>" />
<?php endif?>
<?php if($this->metaDescription!=''):?>
<meta name="description" content="<?php echo CHtml::encode($this->metaDescription); ?>" />
<?php endif?>
<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico" type="image/x-icon" />
<?php //Yii::app()->bootstrap->register(); ?>
<style>
@import url('<?php echo Yii::app()->theme->baseUrl; ?>/inc/css/tipography.css');
</style>
<!--[if IE]>
<style>
@import url('<?php echo Yii::app()->theme->baseUrl; ?>/inc/css/tipographyIE.css');
</style>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/inc/css/main.css" />
</head>

<body>
<div id="page">
<?php
$m = CmsModel::model('SitemapNode',SiteMap::getRoot(),'view');
$a = $m->getData();
$pageTitle = $a->ArticleTitle . (($a->ArticleSubtitle!='')?' - '.$a->ArticleSubtitle:'');
// echo $pageTitle;
?>
<div id="header">
	<div id="logo">
		<a href="<?php echo Yii::app()->urlManager->createUrl('') ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/inc/images/logo.png" title="<?php echo CHtml::encode($pageTitle); ?>" alt="<?php echo CHtml::encode($pageTitle); ?>" /></a>
	</div>
	<div id="siteTitle"><?php echo $pageTitle; ?></div>
</div>
<div id="mainMenu">
<?php
$this->widget('bootstrap.widgets.TbMenu',array(
	'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false, // whether this is a stacked menu
	'items'=>SiteMap::getChildren(SiteMap::getRoot(),false),
));
?>
</div>
<div class="rrr">
		<div id="leftBar">
<!-- BEGIN Sidebar content-->
<?php $this->widget('ext.widgets.AccentWidget', array('id'=>'accent', 'href'=>'accent', 'thumbWidth'=>153)); ?>
<?php $this->widget('ext.widgets.CalendarWidget', array('id'=>'calendar','itemsCount'=>3,)); ?>
<!-- END Sidebar content-->
		</div>
		<div id="mainContainer">
<!-- BEGIN Body content-->
<?php if(isset($this->breadcrumbs) && count($this->breadcrumbs)>0):?>
	<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'homeLink'=>CHtml::link(Yii::t('zii', 'Home'), Yii::app()->createUrl('/')),
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>
<?php echo $content; ?>
<!-- END Body content-->
	</div>
</div>
</div><!-- page -->

<script>
$(window).load(function() {
//jQuery(function($) {
	var c = jQuery("#content").outerHeight()+5;
	if (jQuery("#leftBar").innerHeight() < c)
		jQuery("#leftBar").innerHeight(c);
});
</script>

</body>
</html>