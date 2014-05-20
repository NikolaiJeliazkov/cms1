<?php
class CalendarWidget extends CWidget
{
	public $htmlOptions=array();
	public $itemsCount=3;

	public function init(){
		parent::init();

	}
	public function run() {
		$data = Calendar::search($this->itemsCount)->getData();
		$this->render('CalendarWidget',array('data'=>$data));
	}


}