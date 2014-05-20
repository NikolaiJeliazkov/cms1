<?php
$d = explode('|',$m->ModuleData);
if ($d[1]=='redirect=firstChild') {
	$mm = SiteMap::create($path.'/'.$m->getFirstChild());
} else {
	$mm = $m;
}
$a = $mm->getData();
$this->pageTitle = $a->ArticleTitle . (($a->ArticleSubtitle!='')?' - '.$a->ArticleSubtitle:'');
$this->metaKeywords = $a->ArticleMetaKeywords;
$this->metaDescription = $a->ArticleMetaDescription;
$this->breadcrumbs=$mm->breadcrumbs;

$childrenNodes = SiteMap::getChildren($m->id, false);

?>
<?php if(count($childrenNodes)):?>
<?php
$menuTitle = $a->getTitle();
if ($d[1]=='redirect=firstChild') {
	$aa = $m->getData();
	$menuTitle = $aa->getTitle();
}
?>
<div id="submenu">
<div class="title"><?php echo CHtml::encode($menuTitle); ?></div>
<?php
$this->widget('bootstrap.widgets.TbMenu',array(
	'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
	'stacked'=>true, // whether this is a stacked menu
	'items'=>$childrenNodes,
));
?>
</div>
<?php endif?>
<h1><?php echo CHtml::encode($a->ArticleTitle); ?></h1>
<?php if($a->ArticleSubtitle!=''):?>
<h3><?php echo CHtml::encode($a->ArticleSubtitle); ?></h3>
<?php endif?>
<div class="article clearfix">
<?php
echo $a->ArticleContent;
?>
</div>

<?php $this->widget('ext.widgets.GoToTopWidget'); ?>
