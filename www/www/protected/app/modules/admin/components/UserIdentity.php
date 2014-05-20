<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity {
	private $_UserId;
	public function authenticate() {
		$record=Users::model()->findByAttributes(array('UserEmail'=>$this->username, 'UserActivated'=>1));
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->UserPassword!==Users::encrypt($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->_UserId=$record->UserId;
			$this->setState('UserName', $record->UserName);
			$this->setState('UserEmail', $record->UserEmail);
			$this->setState('UserActivated', $record->UserActivated);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_UserId;
	}

}
