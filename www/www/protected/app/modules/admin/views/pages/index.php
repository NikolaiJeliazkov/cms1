<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
// 		$this->module->id,
);
?>
<h1>
	<?php echo $this->uniqueId . '/' . $this->action->id; ?>
</h1>

<?php
// $sm = new SiteMap();
// $dp = $sm->search();

// $this->widget('ext.treetable.JTreeTable',array(
// 		'id'=>'treeTable',
// 		'dataProvider'=>$dp,
// 		'primaryColumn'=>'id',
// 		'parentColumn'=>'parent',
// 		'columns'=>array(
// 			'id',
// 			'parent',
// 			'url',
// 			array(
// 					'class'=>'bootstrap.widgets.TbButtonColumn',
// 					'htmlOptions'=>array('style'=>'width: 100px'),
// 			),
// 		),
// 		'options'=>array(
// 			'expandable'=>true,
// // 			'initialState'=>'expanded'
// 		),
// ));

?>

