<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="bg">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="bg" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/favicon.ico" type="image/x-icon" />
	<?php //Yii::app()->bootstrap->register(); ?>
	<link rel="stylesheet" type="text/css" href="/inc/admin/css/style.css" />
</head>

<body>

<?php
$menu_items = array(
	array(
		'class'=>'bootstrap.widgets.TbMenu',
		'items'=>array(
			array('label'=>'Страници', 'url'=>Yii::app()->createUrl('admin/pages'), 'visible'=>!Yii::app()->user->isGuest ),
			array('label'=>'Новини', 'url'=>Yii::app()->createUrl('admin/news'), 'visible'=>!Yii::app()->user->isGuest ),
			array('label'=>'Календар', 'url'=>Yii::app()->createUrl('admin/calendar'), 'visible'=>!Yii::app()->user->isGuest ),
			array('label'=>'Галерии', 'url'=>Yii::app()->createUrl('admin/galleries'), 'visible'=>!Yii::app()->user->isGuest ),
// 			array('label'=>'Настройки', 'url'=>'#', 'visible' => !Yii::app()->user->isGuest,
// 				'items'=>array(
// 					array('label'=>'Потребители', 'url'=>Yii::app()->createUrl('admin/users'), 'visible' => !Yii::app()->user->isGuest),
// 					array('label'=>'Езици', 'url'=>Yii::app()->createUrl('admin/languages'), 'visible' => !Yii::app()->user->isGuest ),
// 				),
// 			),
		),
	),
	//Профил
	array(
		'class'=>'bootstrap.widgets.TbMenu',
		'htmlOptions'=>array('class'=>'pull-right'),
		'items'=>array(
			array('label'=>'Вход', 'url'=>Yii::app()->createUrl('admin/default/login'), 'visible' => Yii::app()->user->isGuest, ),
			array('label'=>Yii::app()->user->name, 'url'=>'#', 'visible' => !Yii::app()->user->isGuest,
				'items'=>array(
					array('label'=>'Профил', 'url'=>Yii::app()->createUrl('admin/users/update',array('id'=>Yii::app()->user->id)), ),
					'-',
					array('label'=>'Изход', 'url'=>Yii::app()->createUrl('admin/default/logout'), ),
				),
			),
		),
	),
);
?>
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	'fixed'=>false,
	'brand'=>CHtml::encode(Yii::app()->name),
	'brandUrl'=>Yii::app()->createUrl('admin/pages'),
	'collapse'=>true, // requires bootstrap-responsive.css
	'items'=>$menu_items
)); ?>

<?php // if(isset($this->breadcrumbs) && count($this->breadcrumbs)>0):?>
	<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'homeLink'=>CHtml::link(Yii::app()->language, Yii::app()->createUrl('admin/pages')),
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php // endif;?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php echo $content; ?>

</body>
</html>