<p>
  <?= CHtml::link($model->title, array("post/view", 'id'=>$model->id, 'title'=>$model->title)) ?>
</p>

<p><?= $model->description ?></p>

<? if ($model->slide_url) { ?>
  <p>
    <a href="<?= $model->slide_url ?>" target="_blank">Link</a>
  </p>
<? } ?>