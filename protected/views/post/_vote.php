<p class="js-vote-count"><?= $model->vote_count ?></p>
<p class="js-vote-container">
  <? if ($model->vote_id) { ?>
    You have already vote for this topic.
  <? } else { ?>
    <input type="button" value="Vote"
           class="js-vote-btn" data-id="<?=$model->id?>"/>
  <? } ?>
</p>