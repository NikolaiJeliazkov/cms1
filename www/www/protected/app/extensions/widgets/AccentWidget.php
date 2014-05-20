<?php
class AccentWidget extends CWidget
{
	public $htmlOptions=array();
	public $href='';
	public $thumbWidth=100;
	public $thumbHeight=0;

	public function init(){
		parent::init();

	}
	public function run() {
		try {
			$m = SiteMap::create($this->href);
			$d = explode('|',$m->ModuleData);
			if ($d[1]=='redirect=firstChild') {
				$mm = SiteMap::create($this->href.'/'.$m->getFirstChild());
			} else {
				$mm = $m;
			}
			$a = $mm->getData();
			$title = $a->ArticleTitle;
			$content = $a->ArticleContent;
			$doc = new DOMDocument();
			@$doc->loadHTML($content);
			$imgs = $doc->getElementsByTagName('img');
			$data = null;
			if (count($imgs)>0) {
				foreach ($imgs as $tag) {
					$img = $tag->getAttribute('src');
					$imgPath = dirname(dirname(Yii::app()->getBasePath()));
					$imgFile = $imgPath.$img;
					if (file_exists($imgFile)) {
						$hash = md5(filemtime($imgFile));
						if (!file_exists($imgPath.'/images/thumbs/'.$hash.'.png')) {
							thumbnailsUtil::CreateThumb($imgPath.$img, $imgPath.'/images/thumbs/'.$hash.'.png', $this->thumbWidth, $this->thumbHeight);
						}
						$data = '/images/thumbs/'.$hash.'.png';
						break;
					}
				}
			}
			$this->render('AccentWidget',array('href'=>Yii::app()->urlManager->createUrl('site/'.$this->href), 'alt'=>$title, 'data'=>$data));
		}
		catch (Exception $e) {
		}
	}


}