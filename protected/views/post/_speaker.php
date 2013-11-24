<p> <?= $model->speaker_name ?> </p>

<? if ($model->speaker_description) { ?>
  <p><?= $model->speaker_description ?></p>
<? } ?>

<? if ($model->speaker_url) { ?>
  <p>
    <a href="<?= $model->speaker_url ?>" target="_blank">Link</a>
  </p>
<? } ?>
