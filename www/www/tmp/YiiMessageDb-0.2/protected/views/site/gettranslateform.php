<?php echo CHtml::form(array('site/translate')); ?>

<?php foreach($messages as $category=>$items): ?>

<fieldset><legend><?php echo $category; ?></legend>

<?php foreach($items as $key=>$translation): ?>
<?php

$source_id ="msg[".$category."][".$key."][".$source_lang."]";
$target_id ="msg[".$category."][".$key."][".$sel_target_lang."]";
$target_id_lbl =str_replace('[', "_", $target_id); // <-- Yii bug?
$target_id_lbl =str_replace(']', "", $target_id_lbl);

if (isset($cat_msg_id_arr[$translation])) {
	$tr_key =$cat_msg_id_arr[$translation];
}
else {
	$tr_key =0;
}
if (isset($tr_msg[$category][$sel_target_lang][$tr_key])) {
  $translated_msg =$tr_msg[$category][$sel_target_lang][$tr_key]."";
}
else {
  $translated_msg ='';
}

?>
<div class="simple">
<?php echo CHtml::label($translation, $target_id_lbl); ?>
<?php echo CHtml::textArea($target_id, $translated_msg,array('rows'=>2, 'cols'=>50)); ?>
<?php echo CHtml::hiddenField($source_id, $translation); ?>
</div>
<?php endforeach; ?>

</fieldset>

<?php endforeach; ?>

<div class="action">
<?php echo CHtml::hiddenField('translate_save', '1'); ?>
<?php echo CHtml::hiddenField('sel_target_lang', $sel_target_lang); ?>
<?php echo CHtml::submitButton(Yii::t('main', 'Save')); ?>
<?php //echo CHtml::ajaxButton(Yii::t('main', 'Save'),
  // array('site/savemessages'), array('update'=>'#log_msg_tr')); ?>
</div>

</form>