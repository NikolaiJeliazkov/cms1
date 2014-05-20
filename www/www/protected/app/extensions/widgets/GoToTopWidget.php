<?php
class GoToTopWidget extends CWidget
{
	public function init(){
		parent::init();
		Yii::app()->clientScript->registerScript(
			$this->id,
			'if ($(document).outerHeight()>$(window).height()) {$(\'<div>'.Yii::t('GoToTopWidget','Top').'</div>\').addClass(\'scrollToTop\').click(function(){$(\'html,body\').scrollTop(0);}).appendTo(\'#content\');}',
			CClientScript::POS_READY
		);

	}

}