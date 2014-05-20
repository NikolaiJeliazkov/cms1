<div class="thumb_item" id="<?php echo $data['ImageFileId']; ?>">
<?php echo CHtml::link(
	CHtml::image($data['ImagePath'].'/'.$data['GalleryId'].'/tmb/'.$data['ImageBaseName'], $data['ImageDescription'], array('class'=>'tmb', 'id'=>$data['ImageFileId'].'_thumb')).
	CHtml::tag('div', array('class'=>'title'), $data['ImageDescription']),
	$data['ImagePath'] . '/' . $data['GalleryId'] . '/' . $data['ImageBaseName'],
	array('rel' => 'prettyPhoto[gid-'.$data['GalleryId'].']','title'=>$data['ImageDescription'])
); ?>
</div>
