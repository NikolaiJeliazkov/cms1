<div id="<?php echo $this->id; ?>">
	<div class="title"><?php echo Yii::t('AccentWidget','Accent'); ?></div>
	<a href="<?php echo $href ?>" title="<?php echo $alt; ?>">
	<?php if (is_null($data)) echo $alt; else echo '<img src="' . $data . '" />'; ?>
	</a>
</div>
