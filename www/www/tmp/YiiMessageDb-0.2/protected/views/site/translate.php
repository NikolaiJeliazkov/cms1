<h2><?php echo Yii::app()->name; ?></h2>


<em><?php echo Yii::t('main', 'Working on').": ".$data->name; ?></em>


<div>
<?php echo CHtml::form(); ?>
<?php echo CHtml::label(Yii::t('main', 'Target language').':', "dd_lang_sel"); ?>
<?php echo CHtml::dropDownList("dd_lang_sel", "",$lang_list); ?>
</form>
</div><!-- yiiForm -->

<div id="translate_form" class="yiiForm">

</div><!-- yiiForm -->

<h3>Log:</h3>
<pre id="log_msg_tr">
<?php if (isset($log)) print_r($log); ?>
</pre>

<pre>
<?php print_r($test); ?>
</pre>
