<?php
/**
 * CActiveRecordBehavior for converting checkBoxList data to INT database field
 * Converts data of multiple checkboxes to int 
 * representation by setting bits of integer value
 * (like at *nix chmod command)
 * @author Evgeny Lexunin <lexunin@gmail.com>
 * @link http://www.yiiframework.com/
 * @since 1.0
 */

/* 
Usage:

			ARModel:
 
	public function behaviors()
	{
		return array(
			'StatesBinaryField'=>array(
				'class'=>'path.to.StatesBinaryFieldBehavior',
				'attribute'=>'states',
				'data'=>array(
					'state1'=>'First model state',
					'state2'=>'Second model state',
					'state3'=>'Third model state',
				),
			)
		);
	}

			View file:

<?php
$model=ARModel::model()->findByPK(1);

echo CHtml::beginForm();
echo CHtml::activeCheckBoxList($model, 'states', $model->statesData);
echo CHtml::submitButton();
echo CHtml::endForm();
?>

			Checking state (in any attribute format [int or arr]):
if ($model->checkState('state1')) ...

			Force conversion of attribute:
$model->convertAttribute() or $model->convertAttribute('auto') - converts to opposite format
$model->convertAttribute('int') - coverts to database int representation
$model->convertAttribute('arr') - converts to output array representation


			Selecting models:
Model::model()->statesIncluded(array('state1','state3'))->findAll();
	Will select records:
		('state1','state2','state3')
		('state1','state3')
	Not:
		('state1','state2')

Model::model()->statesExact(array('state1','state3'))->findAll();
	Will select records:
		('state1','state3')
	Not:
		('state1','state2','state3')
		('state1')

Model::model()->statesAtLeast(array('state1','state3'))->findAll();
	Will select records:
		('state1','state2','state3')
		('state1')
		('state3')
	Not:
		('state2')

			Using out of ARModel for forming sql WHERE statement:
$states=array('state1','state3');
$data=array(
	'state1'=>'First model state',
	'state2'=>'Second model state',
	'state3'=>'Third model state',
);
$bitmask=StatesBinaryFieldBehavior::createBitMask($states,$data);	// Returns integer: 5
$dbColumn='table.column'; // Database table column alias
$where_Included		="$dbColumn & $bitmask = $bitmask";
$where_Exact		="$dbColumn = $bitmask";
$where_AtLeast		="$dbColumn & $bitmask != 0";


			Other usage moments:

*	Massive attributes assignment available.

*	Model saving at controller makes as ususal.

*	No need for attribute validation, just set it as save-attribute.

*	Normaly attribute contains an array of selected(setted) states,
	like array('state1','state3')
	and converts it to int representation only before saving.

*	Order of state keys at requested $states doesn't matter
	Example:
	Model::model()->statesAtLeast(array('state1','state3'))
	equal to
	Model::model()->statesAtLeast(array('state3','state1'))

*	Only one field per model available.

*	You a free to rename keys and labels of source $data without affecting to
	database records, BUT NOT THEIR ORDER.

*/
class StatesBinaryFieldBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string Model attribute name. Default to 'states'.
	 */
	public $attribute='states';
	
	/**
	 * Data of possible values and their labels
	 * May be used in {@see CHtml::checkBoxList()}
	 * Use {@see self::getStatesData} to get
	 * 
	 * Example:
	 * array(
	 *		'state1'=>'First state',
	 *		'state2'=>'Second state',
	 * )
	 * 
	 * Usage example:
	 * CHtml::activeCheckBoxList($model, 'attribute', $model->statesData);
	 * 
	 * @var array
	 */
	public $data=array();
	
	/**
	 * Should be attribute auto-converted to database INT format before saving model
	 * @var boolean Default set to true.
	 */
	public $convertBeforeSave=true;
	
	/**
	 * Should be attribute auto-converted to output ARRAY format after saving model
	 * @var boolean Default set to true.
	 */
	public $convertAfterSave=true;
	
	/**
	 * Should be attribute auto-converted to output ARRAY format
	 * after the model is instantiated by a find method.
	 * @var boolean Default set to true.
	 */
	public $convertAfterFind=true;
	
	/**
	 * BeforeSave attribute conversion to INT format
	 * @param CEvent $event 
	 */
	public function beforeSave($event)
	{
		if ($this->convertBeforeSave) $this->toDatabaseInt();
	}
	
	/**
	 * AfterSave attribute conversion to ARRAY format
	 * @param CEvent $event
	 */
	public function afterSave($event)
	{
		if ($this->convertAfterSave) $this->toOutputArray();
	}
	
	/**
	 * AfterFind attribute conversion to ARRAY format
	 * @param CEvent $event
	 */
	public function afterFind($event)
	{
		// INT values from databases stores as STRING type at attributes after data load
		$this->getOwner()->{$this->attribute}=(int)$this->getOwner()->{$this->attribute};
		
		if ($this->convertAfterFind) $this->toOutputArray();
	}
	
	/**
	 * Checking of key state
	 * Checking makes regardless to current conversion format.
	 * If multiple states given, returns true only if all of them is set.
	 * 
	 * Usage:
	 * if ($model->checkState(array('state1','state3'))) echo 'States 1 and 3 is set';
	 * 
	 * @param array $states Selected keys of {@see self::$data} array.
	 * @return boolean Is keys checked.
	 */
	public function checkState($states)
	{
		$data=$this->getOwner()->{$this->attribute};
		if (empty($data)) return false;
		$keys=array_keys($this->data);
		if (is_string($states)) $states=array($states);
		
		if (is_int($data)) {			// Attribute in INT format
			foreach($states as $state) {
				$pos=array_search($state, $keys);
				if ($pos===false || ($data>>$pos&1)===0) return false;
			}
			return true;
		}
		elseif (is_array($data))		// Attribute in ARRAY format
		{
			foreach($states as $state) {
				if (array_search($state,$data)===false) return false;
			}
			return true;
		}
		return false;
	}
	
	/**
	 * Converts attribute to given or opposite format
	 * Options:
	 * int	- convert attribute to INT database format
	 * arr	- convert attribute to ARRAY format (like: array('state1','state3'))
	 *			note: array format may be used in {@see CHtml::checkBoxList()}
	 * auto	- convert attribute to opposite format (int->array or array->int)
	 * @param string $type Type of conversion. Default set to 'auto'.
	 */
	public function convertAttribute($type='auto')
	{
		if ($type==='int') $this->toDatabaseInt();
		elseif ($type==='arr') $this->toOutputArray();
		elseif ($type==='auto') {
			$attribute=$this->getOwner()->{$this->attribute};
			if (is_array($attribute)) $this->toDatabaseInt();
			elseif (is_int($attribute)) $this->toOutputArray();
		}
	}
	
	/**
	 * States data
	 * @return array Returns states data.
	 */
	public function getStatesData()
	{
		return $this->data;
	}
	
	/**
	 * Converts attribute to database INT format
	 * Only if attribute value is array.
	 */
	private function toDatabaseInt()
	{
		$states=$this->getOwner()->{$this->attribute};
		if (!is_array($states)) return;
		$this->getOwner()->{$this->attribute}=$this->convertStates($states);
	}
	
	/**
	 * Converts attribute to output ARRAY format
	 * Array format may be used in {@see CHtml::checkBoxList()}
	 * and such attribute can be set by $_POST request of {@see CActiveForm}.
	 * Only if attribute value is int.
	 */
	private function toOutputArray()
	{
		$states=$this->getOwner()->{$this->attribute};
		if (!is_int($states)) return;
		$keys=array_keys($this->data);
		$new_states=array();
		foreach($keys as $pos=>$k)
			if ($states>>$pos&1) $new_states[]=$k;
		$this->getOwner()->{$this->attribute}=$new_states;
	}
	
	/**
	 * Converts states array to integer representation
	 * @param array $states
	 * @return int 
	 */
	private function convertStates($states)
	{
		if (is_int($states)) return $states;
		if (!is_array($states)) throw new CException('Wrong states format given. Must be an array.');
		return self::createBitMask($states, $this->data);
	}
	
	/**
	 * Adds ARModel conditions for selecting records including all given states
	 * @param array $states Array of states. Example: array('state1','state3')
	 * @return owner 
	 */
	public function statesIncluded($states)
	{
		$owner=$this->getOwner();
		$db=$owner->getDbConnection();
		$criteria=$owner->getDbCriteria();
		$bitmask=$this->convertStates($states);
		$column=$db->quoteColumnName($owner->getTableAlias()).'.'.$db->quoteColumnName($this->attribute);
		$criteria->mergeWith(array(
			'condition'=>$column." & {$bitmask} = {$bitmask}"
			));
		return $owner;
	}
	
	/**
	 * Adds ARModel conditions for selecting records including exactly given states
	 * @param array $states Array of states. Example: array('state1','state3')
	 * @return owner 
	 */
	public function statesExact($states)
	{
		$owner=$this->getOwner();
		$db=$owner->getDbConnection();
		$criteria=$owner->getDbCriteria();
		$bitmask=$this->convertStates($states);
		$column=$db->quoteColumnName($owner->getTableAlias()).'.'.$db->quoteColumnName($this->attribute);
		$criteria->mergeWith(array(
			'condition'=>$column." = ".$bitmask
			));
		return $owner;
	}
	
	/**
	 * Adds ARModel conditions for selecting records including at least one of given states
	 * @param array $states Array of states. Example: array('state1','state3')
	 * @return owner 
	 */
	public function statesAtLeast($states)
	{
		$owner=$this->getOwner();
		$db=$owner->getDbConnection();
		$criteria=$owner->getDbCriteria();
		$bitmask=$this->convertStates($states);
		$column=$db->quoteColumnName($owner->getTableAlias()).'.'.$db->quoteColumnName($this->attribute);
		$criteria->mergeWith(array(
			'condition'=>$column." & {$bitmask} != 0"
			));
		return $owner;
	}
	
	/**
	 * Creates integer representation of given states
	 * 
	 * Usage:
	 * 
	 * $states=array('state1','state3');
	 * $data=array(
	 *		'state1'=>'First model state',
	 *		'state2'=>'Second model state',
	 *		'state3'=>'Third model state',
	 * );
	 * $bitmask=StatesBinaryFieldBehavior::createBitMask($states,$data);	// Returns integer: 5
	 * 
	 * @param array $states Array of setted states
	 * @param data $data Array of all available states
	 * @return int Interger representation of states
	 */
	public static function createBitMask($states, $data)
	{
		$keys=array_keys($data);
		$new_states=0;
		foreach($states as $state)
		{
			if (isset($data[$state])) {
				$pos=array_search($state, $keys);
				$new_states=1<<$pos|$new_states;
			}
		}
		return $new_states;
	}
	
	/*
	 * @TODO Create states validation
	 */
	public function validateStates($states)
	{
		
	}
}