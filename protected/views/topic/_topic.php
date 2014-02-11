<p>
  <?= CHtml::link($model->title, array("topic/view", 'id'=>$model->id, 'title'=>$model->title)) ?>
</p>

<p><?= $model->description ?></p>

<? if ($model->duration) { ?>
  <p>Duration: <?= $model->duration ?> minutes</p>
<? } ?>

<? if ($model->language) { ?>
  <p>Language: <?= $model->language ?></p>
<? } ?>

<? if ($model->slide_url) { ?>
  <p>
    <a href="<?= $model->slide_url ?>" target="_blank">Link</a>
  </p>
<? } ?>