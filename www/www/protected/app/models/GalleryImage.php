<?php
class GalleryImage extends CmsModel
{
	public $ImageId;
	public $GalleryId;
	public $ImageOrder;
	public $ImageFileId;
	public $ImageBaseName;
	public $ImageExtension;
	public $ImageTitle;
	public $ImageDescription;
	public $ImageSize;
	public $ImageType;
	public $ImagePath;
	public $ImageUrl;
	public $ImageCreated;
	public $ImageUpdated;

	public function getById($id) {
		$sql = "
SELECT
	ImageId,
	GalleryId,
	ImageOrder,
	ImageFileId,
	ImageBaseName,
	ImageExtension,
	ImageTitle,
	ImageDescription,
	ImageSize,
	ImageType,
	ImagePath,
	ImageUrl,
	ImageCreated,
	ImageUpdated
FROM
	images
WHERE
	ImageId = :id
";
		$node=Yii::app()->db->createCommand($sql)->queryRow(true,array(':id'=>$id));
		if ($node === false) {
			return false;
		}
		$this->ImageId = $node['ImageId'];
		$this->GalleryId = $node['GalleryId'];
		$this->ImageOrder = $node['ImageOrder'];
		$this->ImageFileId = $node['ImageFileId'];
		$this->ImageBaseName = $node['ImageBaseName'];
		$this->ImageExtension = $node['ImageExtension'];
		$this->ImageTitle = $node['ImageTitle'];
		$this->ImageDescription = $node['ImageDescription'];
		$this->ImageSize = $node['ImageSize'];
		$this->ImageType = $node['ImageType'];
		$this->ImagePath = $node['ImagePath'];
		$this->ImageUrl = $node['ImageUrl'];
		$this->ImageCreated = $node['ImageCreated'];
		$this->ImageUpdated = $node['ImageUpdated'];
		return true;
	}

	public static function search($GalleryId, $pageSize=false) {
		$pagination = ($pageSize===false) ? false : array('pageSize'=>$pageSize);
		$sql = "
select
  count(*)
from
  images
where
  GalleryId = :GalleryId
";
		$command= Yii::app()->db->createCommand($sql);
		$command->bindParam(":GalleryId",$GalleryId);
		$count=$command->queryScalar();

		$sql = "
SELECT
	ImageId,
	GalleryId,
	ImageOrder,
	ImageFileId,
	ImageBaseName,
	ImageExtension,
	ImageTitle,
	ImageDescription,
	ImageSize,
	ImageType,
	ImagePath,
	ImageUrl,
	ImageCreated,
	ImageUpdated
FROM
	images
WHERE
  GalleryId = :GalleryId
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'ImageId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'ImageOrder' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'ImageOrder',
						),
				),
				'pagination'=>$pagination,
				'params'=>array(
						':GalleryId'=>$GalleryId,
				), //needed if $id is not null
		));
		$dataProvider->setId('ImageId');
		return $dataProvider;
	}


	public function getTitle() {
		if ($this->scenario=='' || $this->scenario=='index') {
			return Yii::t('core','Gallery');
		}
		return $this->ImageTitle;
	}

}