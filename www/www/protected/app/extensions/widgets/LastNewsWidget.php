<?php
class LastNewsWidget extends CWidget
{
	public $htmlOptions=array();
	public $itemsCount=2;

	public function init(){
		parent::init();

	}
	public function run() {
		$data = News::search($this->itemsCount)->getData();
		$this->render('LastNewsWidget',array('data'=>$data));
	}


}