<div class="thumb_item" id="img_<?php echo $data['ImageId']; ?>">
<?php echo CHtml::link(
	CHtml::image($data['ImagePath'].'/'.$data['GalleryId'].'/tmb/'.$data['ImageBaseName'], $data['ImageDescription'], array('class'=>'tmb', 'id'=>'thumb_'.$data['ImageFileId'])).
	CHtml::tag('div', array('class'=>'title'), $data['ImageDescription']),
	$data['ImagePath'] . '/' . $data['GalleryId'] . '/' . $data['ImageBaseName'],
	array('rel' => 'prettyPhoto[gid-'.$data['GalleryId'].']','title'=>$data['ImageDescription'])
); ?>
</div>
