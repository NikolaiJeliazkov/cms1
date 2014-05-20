<?php
$a = CmsModel::model('Gallery',$data['GalleryId'],'preview');
$dp = GalleryImage::search($data['GalleryId'], 1);
$data = $dp->getData();
$data = $data[0];
?>
<div class="thumb_item" id="img_<?php echo $data['ImageId']; ?>">
<?php echo CHtml::link(
	CHtml::image($data['ImagePath'].'/'.$data['GalleryId'].'/tmb/'.$data['ImageBaseName'], $a->ArticleTitle, array('class'=>'tmb', 'id'=>'thumb_'.$data['ImageId'])).
	CHtml::tag('div', array('class'=>'title'), $a->ArticleTitle),
	array('view', 'id'=>$a->GalleryId),
	array('rel' => 'prettyPhoto[gid-'.$data['GalleryId'].']','title'=>$a->ArticleTitle)
); ?>
</div>
